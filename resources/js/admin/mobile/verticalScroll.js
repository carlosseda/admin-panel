import {startWait, stopWait} from "./wait";
import {trackingScroll, trackingPagination} from "./tracking";
import {renderTable} from './crudTable';

export function scrollWindowElement (scrollWindowElement){

    'use strict';

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentYPosition = 0;
    let paginationVisible = false;
    let parentElementHeight = scrollWindowElement.parentElement.getBoundingClientRect().height;

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

        let differenceInY = (initialTouchPos.y - lastTouchPos.y);
        let newYTransform  = (currentYPosition - differenceInY);
        let transformStyle  = newYTransform +'px';
        let offsetBottom = scrollWindowElement.getBoundingClientRect().height + scrollWindowElement.offsetTop;

        if(differenceInY < 1){

            if(scrollWindowElement.style.top > 0+'px'){
                transformStyle = '0px';
                scrollWindowElement.style.top = transformStyle;
            }

            if(scrollWindowElement.style.top < 0+'px'){
                scrollWindowElement.style.top = transformStyle;
            }
        }

        else{

            if(offsetBottom > parentElementHeight){
                scrollWindowElement.style.top = transformStyle;
            }
        }

        if(scrollWindowElement.getBoundingClientRect().bottom < window.innerHeight ){
            
            if(!paginationVisible){
                
                scrollPagination();

                paginationVisible = true;
            }
        }; 
      
        rafPending = false;
    }

    function updateScrollRestPosition() {

        let offsetBottom = scrollWindowElement.getBoundingClientRect().height + scrollWindowElement.offsetTop;

        if(scrollWindowElement.style.top < 0+'px'){

            let differenceInY = (initialTouchPos.y - lastTouchPos.y);

            if(offsetBottom > parentElementHeight){
                currentYPosition = (currentYPosition - differenceInY);
            }else{
                if(!paginationVisible){
                
                    scrollPagination();
    
                    paginationVisible = true;
                }
            }
            
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

    function scrollPagination() {

        let scrollPaginationRequest = async () => {

            try {

                let pagination = scrollWindowElement.querySelector('.pagination');
                let url = pagination.dataset.pagination;
                let lastPage = pagination.dataset.lastpage;
                let urlParams = new URL(url);
                let nextPage = parseInt(urlParams.searchParams.get('page'));
                let updateMove = {
                    "origin": "mobile", 
                    "route": window.location.pathname,
                    "move": "next_elements",
                    "entity": scrollWindowElement.id,
                    "page":  nextPage
                }

                if(nextPage <= lastPage){

                    startWait();
                    
                    await axios.get(url).then(response => {
                        
                        if(updateMove.entity = 'table'){
    
                            scrollWindowElement.insertAdjacentHTML('beforeend', response.data.table);
                            ++nextPage;
                            urlParams.searchParams.set('page', nextPage);
                            pagination.dataset.pagination = urlParams.toString();

                            renderTable();
                            stopWait();
                            trackingPagination(updateMove);
                        }
                    });

                }

            } catch (error) {
                console.error(error);
            }
        };

        return scrollPaginationRequest();
    }
    
    scrollWindowElement.addEventListener('touchstart', this.handleGestureStart, {passive: true} );
    scrollWindowElement.addEventListener('touchmove', this.handleGestureMove, {passive: true} );
    scrollWindowElement.addEventListener('touchend', this.handleGestureEnd, true);
    scrollWindowElement.addEventListener('touchcancel', this.handleGestureEnd, true);
};   