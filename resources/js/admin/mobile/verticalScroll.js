export function scrollWindowElement (element){

    'use strict';

    let scrollWindowElement = element;

    let STATE_DEFAULT = 1;
    let STATE_TOP_SIDE = 2;
    let STATE_BOTTOM_SIDE = 3;

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentYPosition = 0;
    let currentState = STATE_DEFAULT;
    let handleSize = 10;

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


    function updateScrollRestPosition() {

        let transformStyle;
        let differenceInY = initialTouchPos.y - lastTouchPos.y;
        
        currentYPosition = currentYPosition - differenceInY;

        if(Math.sign(differenceInY) == 1) {
            currentYPosition = currentYPosition + 200;
            console.log(currentYPosition);
        }
        
        if(Math.sign(differenceInY) == -1) {
            currentYPosition = currentYPosition - 200;
            console.log(currentYPosition);
        }

        if(scrollWindowElement.offsetTop < 0){

            transformStyle = 'translateY('+currentYPosition+'px)';

            scrollWindowElement.style.msTransform = transformStyle;
            scrollWindowElement.style.MozTransform = transformStyle;
            scrollWindowElement.style.webkitTransform = transformStyle;
            scrollWindowElement.style.transform = transformStyle;

            scrollWindowElement.style.transition = 'all 300ms ease-out';
        };
    }

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
        let newYTransform  = (currentYPosition - differenceInY)+'px';
        let transformStyle = 'translateY('+newYTransform+')';

        scrollWindowElement.style.webkitTransform = transformStyle;
        scrollWindowElement.style.MozTransform = transformStyle;
        scrollWindowElement.style.msTransform = transformStyle;
        scrollWindowElement.style.transform = transformStyle;

        rafPending = false;
    }

    
    scrollWindowElement.addEventListener('touchstart', this.handleGestureStart, {passive: true} );
    scrollWindowElement.addEventListener('touchmove', this.handleGestureMove, {passive: true} );
    scrollWindowElement.addEventListener('touchend', this.handleGestureEnd, true);
    scrollWindowElement.addEventListener('touchcancel', this.handleGestureEnd, true);
};   