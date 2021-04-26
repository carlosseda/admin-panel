import {trackingScroll, trackingPagination} from "./tracking";
import {renderTable} from './crudTable';

export function scrollWindowElement (scrollWindowElement){

    'use strict';

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentYPosition = 0;
    let paginationVisible = false;

    this.handleGestureStart = function(evt) {

        if(evt.touches && evt.touches.length > 1) {
            return;
        }

        if (scrollWindowElement.PointerEvent) {
            evt.target.setPointerCapture(evt.pointerId);
        } else {
            document.addEventListener('mousemove', this.handleGestureMove, true);
            document.addEventListener('mouseup', this.handleGestureEnd, true);
        }

        initialTouchPos = getGesturePointFromEvent(evt);

    }.bind(this);

    this.handleGestureMove = function (evt) {

        if(!initialTouchPos) {
            return;
        }

        lastTouchPos = getGesturePointFromEvent(evt);

        if(rafPending) {
            return;
        }

        rafPending = true;

        window.requestAnimFrame(onAnimFrame);

    }.bind(this);

    this.handleGestureEnd = function(evt) {

        evt.preventDefault();

        if(evt.touches && evt.touches.length > 0) {
            return;
        }

        rafPending = false;

        if (scrollWindowElement.PointerEvent) {
            evt.target.releasePointerCapture(evt.pointerId);
        } else {
            document.removeEventListener('mousemove', this.handleGestureMove, true);
            document.removeEventListener('mouseup', this.handleGestureEnd, true);
        }

        updateScrollRestPosition();

        initialTouchPos = null;

    }.bind(this);

    
    function getGesturePointFromEvent(evt) {

        let point = {};

        if(evt.targetTouches) {
            point.y = evt.targetTouches[0].clientY;
        } else {
            point.y = evt.clientY;
        }

        return point; 

    }

    function onAnimFrame() {

        if(!rafPending) {
            return;
        }

        let differenceInY = initialTouchPos.y - lastTouchPos.y;
        let newYTransform  = currentYPosition - differenceInY;
        let transformStyle  = newYTransform +'px';

        if(differenceInY < 1){

            if(scrollWindowElement.style.top > 0+'px'){
                transformStyle = '0px';
                scrollWindowElement.style.top = transformStyle;
            }

            if(scrollWindowElement.style.top < 0+'px'){
                scrollWindowElement.style.top = transformStyle;
            }
        }else{
            scrollWindowElement.style.top = transformStyle;
        }

        if(scrollWindowElement.getBoundingClientRect().bottom < window.innerHeight ){
            
            if(!paginationVisible){
                
                pagination();
                paginationVisible = true;
            }
        }; 
      
        rafPending = false;
    }

    function updateScrollRestPosition() {

       
        if(scrollWindowElement.style.top < 0+'px'){

            let differenceInY = (initialTouchPos.y - lastTouchPos.y);
            currentYPosition = (currentYPosition - differenceInY);

            if(differenceInY > 0) {
                
                let updateMove = {
                    "difference_in_y": differenceInY, 
                    "current_y_position": currentYPosition,
                    "origin": "mobile", 
                    "route": window.location.pathname,
                    "move": "toBottom",
                    "entity": scrollWindowElement.id 
                }

                trackingScroll(updateMove);

            } else if(differenceInY < 0) {

                let updateMove = {
                    "difference_in_y": differenceInY, 
                    "current_y_position": currentYPosition,
                    "origin": "mobile", 
                    "route": window.location.pathname,
                    "move": "toTop",
                    "entity": scrollWindowElement.id 
                }

                trackingScroll(updateMove); 
            };

                paginationVisible = false;
        }
    }

    function pagination() {

        let paginationRequest = async () => {

            try {

                let lastPage = scrollWindowElement.dataset.lastpage;
                let url = scrollWindowElement.dataset.pagination;
                let currentPage = url.replace( /^\D+/g, '');

                let updateMove = {
                    "origin": "mobile", 
                    "route": window.location.pathname,
                    "move": "next_elements",
                    "entity": scrollWindowElement.id,
                    "page":  currentPage
                }
                
                await axios.get(url).then(response => {
                    
                    if(updateMove.entity = 'table'){

                        if(response.data.table.match(/table-row/g)){

                            scrollWindowElement.insertAdjacentHTML('beforeend', response.data.table);

                            let nextPage = parseInt(currentPage);
                            nextPage++;
                            scrollWindowElement.dataset.pagination = url.replace(/[0-9]/g, nextPage)

                            trackingPagination(updateMove, currentPage);
                            renderTable();
                        }
                    }
                });

            } catch (error) {
                console.error(error);
            }
        };

        paginationRequest();
    }
    
    scrollWindowElement.addEventListener('touchstart', this.handleGestureStart, {passive: true} );
    scrollWindowElement.addEventListener('touchmove', this.handleGestureMove, {passive: true} );
    scrollWindowElement.addEventListener('touchend', this.handleGestureEnd, true);
    scrollWindowElement.addEventListener('touchcancel', this.handleGestureEnd, true);
};   