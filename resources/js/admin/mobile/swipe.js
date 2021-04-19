import {editElement} from './crudTable';

export function swipeRevealItem (element){

    'use strict';

    let STATE_DEFAULT = 1;
    let STATE_LEFT_SIDE = 2;
    let STATE_RIGHT_SIDE = 3;

    let leftSwipes = document.querySelectorAll('.left-swipe');
    let rightSwipes = document.querySelectorAll('.right-swipe');
    let swipeFrontElement = element.querySelector('.swipe-front');

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentXPosition = 0;
    let currentState = STATE_DEFAULT;
    let handleSize = 10;
    let leftSwipeVisible = 0;
    let rightSwipeVisible = 0;
    let itemWidth = swipeFrontElement.clientWidth;
    let slopValue = itemWidth * (2/4);

    this.resize = function() {
        itemWidth = swipeFrontElement.clientWidth;
        slopValue = itemWidth * (2/4);
    };

    this.handleGestureStart = function(evt) {

        evt.preventDefault();

        if(evt.touches && evt.touches.length > 1) {
            return;
        }

        if (window.PointerEvent) {
            evt.target.setPointerCapture(evt.pointerId);
        } else {
            document.addEventListener('mousemove', this.handleGestureMove, true);
            document.addEventListener('mouseup', this.handleGestureEnd, true);
        }

        initialTouchPos = getGesturePointFromEvent(evt);
        swipeFrontElement.style.transition = 'initial';

    }.bind(this);

    this.handleGestureMove = function (evt) {

        evt.preventDefault();

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

        if (window.PointerEvent) {
            evt.target.releasePointerCapture(evt.pointerId);
        } else {
            document.removeEventListener('mousemove', this.handleGestureMove, true);
            document.removeEventListener('mouseup', this.handleGestureEnd, true);
        }

        updateSwipeRestPosition();

        leftSwipeVisible = 0;
        rightSwipeVisible = 0;
        initialTouchPos = null;

    }.bind(this);

    
    function updateSwipeRestPosition() {

        let differenceInX = initialTouchPos.x - lastTouchPos.x;
        currentXPosition = currentXPosition - differenceInX;

        let newState = STATE_DEFAULT;

        if(Math.abs(differenceInX) > slopValue) {
            
            if(currentState === STATE_DEFAULT) {
                if(differenceInX > 0) {
                    newState = STATE_LEFT_SIDE;
                } else {
                    newState = STATE_RIGHT_SIDE;
                }
            } else {
                if(currentState === STATE_LEFT_SIDE && differenceInX > 0) {
                    newState = STATE_DEFAULT;
                } else if(currentState === STATE_RIGHT_SIDE && differenceInX < 0) {
                    newState = STATE_DEFAULT;
                }
            }
        } else {
            newState = currentState;
        }

        changeState(newState);

        swipeFrontElement.style.transition = 'all 150ms ease-out';
    }

    function changeState(newState) {

        let transformStyle;

        switch(newState) {

            case STATE_DEFAULT:
                currentXPosition = 0;
                break;
            case STATE_LEFT_SIDE:
                currentXPosition = -(itemWidth - handleSize);
                break;
            case STATE_RIGHT_SIDE:
                currentXPosition = itemWidth - handleSize;
                break;
        }

        if(currentXPosition > 1){


            rightSwipes.forEach(rightSwipe => {

                if(rightSwipe.dataset.swipe == swipeFrontElement.dataset.swipe){
                    editElement(rightSwipe.dataset.url);
                }
            });
          

        }else if(currentXPosition < -1){
            
            leftSwipes.forEach(leftSwipe => {

                if(leftSwipe.dataset.swipe == swipeFrontElement.dataset.swipe){
                    console.log(leftSwipe.dataset.url);
                }
            });
        }

        transformStyle = 'translateX('+currentXPosition+'px)';

        swipeFrontElement.style.msTransform = transformStyle;
        swipeFrontElement.style.MozTransform = transformStyle;
        swipeFrontElement.style.webkitTransform = transformStyle;
        swipeFrontElement.style.transform = transformStyle;

        currentState = newState;    
    }

    function getGesturePointFromEvent(evt) {

        let point = {};

        if(evt.targetTouches) {
            point.x = evt.targetTouches[0].clientX;
            point.y = evt.targetTouches[0].clientY;
        } else {
            point.x = evt.clientX;
            point.y = evt.clientY;
        }

        return point;
    }

    function onAnimFrame() {

        if(!rafPending) {
            return;
        }

        let differenceInX = initialTouchPos.x - lastTouchPos.x;
        let newXTransform  = (currentXPosition - differenceInX)+'px';
        let transformStyle = 'translateX('+newXTransform+')';

        if(Math.sign(differenceInX) == 1 && leftSwipeVisible == 0){

            let swipeActive = document.getElementById('swipe-active');

            if(swipeActive !== null){
                swipeActive.removeAttribute('id');
            }

            leftSwipes.forEach(leftSwipe => {

                if(leftSwipe.dataset.swipe == swipeFrontElement.dataset.swipe){
                    leftSwipe.id = 'swipe-active';
                }
            });

            leftSwipeVisible = 1;
            rightSwipeVisible = 0;

        }else if(Math.sign(differenceInX) == -1 && rightSwipeVisible == 0){

            let swipeActive = document.getElementById('swipe-active');
 
            if(swipeActive !== null){
                swipeActive.removeAttribute('id');
            }

            rightSwipes.forEach(rightSwipe => {

                if(rightSwipe.dataset.swipe == swipeFrontElement.dataset.swipe){
                    rightSwipe.id = 'swipe-active';
                }
            });

            leftSwipeVisible = 0;
            rightSwipeVisible = 1;
        }

        swipeFrontElement.style.webkitTransform = transformStyle;
        swipeFrontElement.style.MozTransform = transformStyle;
        swipeFrontElement.style.msTransform = transformStyle;
        swipeFrontElement.style.transform = transformStyle;

        rafPending = false;
    }
    
    if (window.PointerEvent) {
        swipeFrontElement.addEventListener('pointerdown', this.handleGestureStart, true);
        swipeFrontElement.addEventListener('pointermove', this.handleGestureMove, true);
        swipeFrontElement.addEventListener('pointerup', this.handleGestureEnd, true);
        swipeFrontElement.addEventListener('pointercancel', this.handleGestureEnd, true);
    } else {
        swipeFrontElement.addEventListener('touchstart', this.handleGestureStart, true);
        swipeFrontElement.addEventListener('touchmove', this.handleGestureMove, true);
        swipeFrontElement.addEventListener('touchend', this.handleGestureEnd, true);
        swipeFrontElement.addEventListener('touchcancel', this.handleGestureEnd, true);
        swipeFrontElement.addEventListener('mousedown', this.handleGestureStart, true);
    }    
};   