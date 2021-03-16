(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/@revolist/revogrid/dist/esm-es5/resize-observer-56b7b34f.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/@revolist/revogrid/dist/esm-es5/resize-observer-56b7b34f.js ***!
  \**********************************************************************************/
/*! exports provided: ResizeObserver, ResizeObserverEntry */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ResizeObserver", function() { return ResizeObserver; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ResizeObserverEntry", function() { return ResizeObserverEntry; });
var resizeObservers=[];var hasActiveObservations=function(){return resizeObservers.some((function(e){return e.activeTargets.length>0}))};var hasSkippedObservations=function(){return resizeObservers.some((function(e){return e.skippedTargets.length>0}))};var msg="ResizeObserver loop completed with undelivered notifications.";var deliverResizeLoopError=function(){var e;if(typeof ErrorEvent==="function"){e=new ErrorEvent("error",{message:msg})}else{e=document.createEvent("Event");e.initEvent("error",false,false);e.message=msg}window.dispatchEvent(e)};var ResizeObserverBoxOptions;(function(e){e["BORDER_BOX"]="border-box";e["CONTENT_BOX"]="content-box";e["DEVICE_PIXEL_CONTENT_BOX"]="device-pixel-content-box"})(ResizeObserverBoxOptions||(ResizeObserverBoxOptions={}));var DOMRectReadOnly=function(){function e(e,t,r,i){this.x=e;this.y=t;this.width=r;this.height=i;this.top=this.y;this.left=this.x;this.bottom=this.top+this.height;this.right=this.left+this.width;return Object.freeze(this)}e.prototype.toJSON=function(){var e=this,t=e.x,r=e.y,i=e.top,n=e.right,o=e.bottom,s=e.left,a=e.width,c=e.height;return{x:t,y:r,top:i,right:n,bottom:o,left:s,width:a,height:c}};e.fromRect=function(t){return new e(t.x,t.y,t.width,t.height)};return e}();var isSVG=function(e){return e instanceof SVGElement&&"getBBox"in e};var isHidden=function(e){if(isSVG(e)){var t=e.getBBox(),r=t.width,i=t.height;return!r&&!i}var n=e,o=n.offsetWidth,s=n.offsetHeight;return!(o||s||e.getClientRects().length)};var isElement=function(e){var t,r;var i=(r=(t=e)===null||t===void 0?void 0:t.ownerDocument)===null||r===void 0?void 0:r.defaultView;return!!(i&&e instanceof i.Element)};var isReplacedElement=function(e){switch(e.tagName){case"INPUT":if(e.type!=="image"){break}case"VIDEO":case"AUDIO":case"EMBED":case"OBJECT":case"CANVAS":case"IFRAME":case"IMG":return true}return false};var global=typeof window!=="undefined"?window:{};var cache=new WeakMap;var scrollRegexp=/auto|scroll/;var verticalRegexp=/^tb|vertical/;var IE=/msie|trident/i.test(global.navigator&&global.navigator.userAgent);var parseDimension=function(e){return parseFloat(e||"0")};var size=function(e,t,r){if(e===void 0){e=0}if(t===void 0){t=0}if(r===void 0){r=false}return Object.freeze({inlineSize:(r?t:e)||0,blockSize:(r?e:t)||0})};var zeroBoxes=Object.freeze({devicePixelContentBoxSize:size(),borderBoxSize:size(),contentBoxSize:size(),contentRect:new DOMRectReadOnly(0,0,0,0)});var calculateBoxSizes=function(e,t){if(t===void 0){t=false}if(cache.has(e)&&!t){return cache.get(e)}if(isHidden(e)){cache.set(e,zeroBoxes);return zeroBoxes}var r=getComputedStyle(e);var i=isSVG(e)&&e.ownerSVGElement&&e.getBBox();var n=!IE&&r.boxSizing==="border-box";var o=verticalRegexp.test(r.writingMode||"");var s=!i&&scrollRegexp.test(r.overflowY||"");var a=!i&&scrollRegexp.test(r.overflowX||"");var c=i?0:parseDimension(r.paddingTop);var v=i?0:parseDimension(r.paddingRight);var u=i?0:parseDimension(r.paddingBottom);var l=i?0:parseDimension(r.paddingLeft);var h=i?0:parseDimension(r.borderTopWidth);var f=i?0:parseDimension(r.borderRightWidth);var d=i?0:parseDimension(r.borderBottomWidth);var p=i?0:parseDimension(r.borderLeftWidth);var b=l+v;var g=c+u;var z=p+f;var O=h+d;var x=!a?0:e.offsetHeight-O-e.clientHeight;var R=!s?0:e.offsetWidth-z-e.clientWidth;var m=n?b+z:0;var E=n?g+O:0;var w=i?i.width:parseDimension(r.width)-m-R;var y=i?i.height:parseDimension(r.height)-E-x;var B=w+b+R+z;var S=y+g+x+O;var T=Object.freeze({devicePixelContentBoxSize:size(Math.round(w*devicePixelRatio),Math.round(y*devicePixelRatio),o),borderBoxSize:size(B,S,o),contentBoxSize:size(w,y,o),contentRect:new DOMRectReadOnly(l,c,w,y)});cache.set(e,T);return T};var calculateBoxSize=function(e,t,r){var i=calculateBoxSizes(e,r),n=i.borderBoxSize,o=i.contentBoxSize,s=i.devicePixelContentBoxSize;switch(t){case ResizeObserverBoxOptions.DEVICE_PIXEL_CONTENT_BOX:return s;case ResizeObserverBoxOptions.BORDER_BOX:return n;default:return o}};var ResizeObserverEntry=function(){function e(e){var t=calculateBoxSizes(e);this.target=e;this.contentRect=t.contentRect;this.borderBoxSize=[t.borderBoxSize];this.contentBoxSize=[t.contentBoxSize];this.devicePixelContentBoxSize=[t.devicePixelContentBoxSize]}return e}();var calculateDepthForNode=function(e){if(isHidden(e)){return Infinity}var t=0;var r=e.parentNode;while(r){t+=1;r=r.parentNode}return t};var broadcastActiveObservations=function(){var e=Infinity;var t=[];resizeObservers.forEach((function r(i){if(i.activeTargets.length===0){return}var n=[];i.activeTargets.forEach((function t(r){var i=new ResizeObserverEntry(r.target);var o=calculateDepthForNode(r.target);n.push(i);r.lastReportedSize=calculateBoxSize(r.target,r.observedBox);if(o<e){e=o}}));t.push((function e(){i.callback.call(i.observer,n,i.observer)}));i.activeTargets.splice(0,i.activeTargets.length)}));for(var r=0,i=t;r<i.length;r++){var n=i[r];n()}return e};var gatherActiveObservationsAtDepth=function(e){resizeObservers.forEach((function t(r){r.activeTargets.splice(0,r.activeTargets.length);r.skippedTargets.splice(0,r.skippedTargets.length);r.observationTargets.forEach((function t(i){if(i.isActive()){if(calculateDepthForNode(i.target)>e){r.activeTargets.push(i)}else{r.skippedTargets.push(i)}}}))}))};var process=function(){var e=0;gatherActiveObservationsAtDepth(e);while(hasActiveObservations()){e=broadcastActiveObservations();gatherActiveObservationsAtDepth(e)}if(hasSkippedObservations()){deliverResizeLoopError()}return e>0};var trigger;var callbacks=[];var notify=function(){return callbacks.splice(0).forEach((function(e){return e()}))};var queueMicroTask=function(e){if(!trigger){var t=0;var r=document.createTextNode("");var i={characterData:true};new MutationObserver((function(){return notify()})).observe(r,i);trigger=function(){r.textContent=""+(t?t--:t++)}}callbacks.push(e);trigger()};var queueResizeObserver=function(e){queueMicroTask((function t(){requestAnimationFrame(e)}))};var watching=0;var isWatching=function(){return!!watching};var CATCH_PERIOD=250;var observerConfig={attributes:true,characterData:true,childList:true,subtree:true};var events=["resize","load","transitionend","animationend","animationstart","animationiteration","keyup","keydown","mouseup","mousedown","mouseover","mouseout","blur","focus"];var time=function(e){if(e===void 0){e=0}return Date.now()+e};var scheduled=false;var Scheduler=function(){function e(){var e=this;this.stopped=true;this.listener=function(){return e.schedule()}}e.prototype.run=function(e){var t=this;if(e===void 0){e=CATCH_PERIOD}if(scheduled){return}scheduled=true;var r=time(e);queueResizeObserver((function(){var i=false;try{i=process()}finally{scheduled=false;e=r-time();if(!isWatching()){return}if(i){t.run(1e3)}else if(e>0){t.run(e)}else{t.start()}}}))};e.prototype.schedule=function(){this.stop();this.run()};e.prototype.observe=function(){var e=this;var t=function(){return e.observer&&e.observer.observe(document.body,observerConfig)};document.body?t():global.addEventListener("DOMContentLoaded",t)};e.prototype.start=function(){var e=this;if(this.stopped){this.stopped=false;this.observer=new MutationObserver(this.listener);this.observe();events.forEach((function(t){return global.addEventListener(t,e.listener,true)}))}};e.prototype.stop=function(){var e=this;if(!this.stopped){this.observer&&this.observer.disconnect();events.forEach((function(t){return global.removeEventListener(t,e.listener,true)}));this.stopped=true}};return e}();var scheduler=new Scheduler;var updateCount=function(e){!watching&&e>0&&scheduler.start();watching+=e;!watching&&scheduler.stop()};var skipNotifyOnElement=function(e){return!isSVG(e)&&!isReplacedElement(e)&&getComputedStyle(e).display==="inline"};var ResizeObservation=function(){function e(e,t){this.target=e;this.observedBox=t||ResizeObserverBoxOptions.CONTENT_BOX;this.lastReportedSize={inlineSize:0,blockSize:0}}e.prototype.isActive=function(){var e=calculateBoxSize(this.target,this.observedBox,true);if(skipNotifyOnElement(this.target)){this.lastReportedSize=e}if(this.lastReportedSize.inlineSize!==e.inlineSize||this.lastReportedSize.blockSize!==e.blockSize){return true}return false};return e}();var ResizeObserverDetail=function(){function e(e,t){this.activeTargets=[];this.skippedTargets=[];this.observationTargets=[];this.observer=e;this.callback=t}return e}();var observerMap=new WeakMap;var getObservationIndex=function(e,t){for(var r=0;r<e.length;r+=1){if(e[r].target===t){return r}}return-1};var ResizeObserverController=function(){function e(){}e.connect=function(e,t){var r=new ResizeObserverDetail(e,t);observerMap.set(e,r)};e.observe=function(e,t,r){var i=observerMap.get(e);var n=i.observationTargets.length===0;if(getObservationIndex(i.observationTargets,t)<0){n&&resizeObservers.push(i);i.observationTargets.push(new ResizeObservation(t,r&&r.box));updateCount(1);scheduler.schedule()}};e.unobserve=function(e,t){var r=observerMap.get(e);var i=getObservationIndex(r.observationTargets,t);var n=r.observationTargets.length===1;if(i>=0){n&&resizeObservers.splice(resizeObservers.indexOf(r),1);r.observationTargets.splice(i,1);updateCount(-1)}};e.disconnect=function(e){var t=this;var r=observerMap.get(e);r.observationTargets.slice().forEach((function(r){return t.unobserve(e,r.target)}));r.activeTargets.splice(0,r.activeTargets.length)};return e}();var ResizeObserver=function(){function e(e){if(arguments.length===0){throw new TypeError("Failed to construct 'ResizeObserver': 1 argument required, but only 0 present.")}if(typeof e!=="function"){throw new TypeError("Failed to construct 'ResizeObserver': The callback provided as parameter 1 is not a function.")}ResizeObserverController.connect(this,e)}e.prototype.observe=function(e,t){if(arguments.length===0){throw new TypeError("Failed to execute 'observe' on 'ResizeObserver': 1 argument required, but only 0 present.")}if(!isElement(e)){throw new TypeError("Failed to execute 'observe' on 'ResizeObserver': parameter 1 is not of type 'Element")}ResizeObserverController.observe(this,e,t)};e.prototype.unobserve=function(e){if(arguments.length===0){throw new TypeError("Failed to execute 'unobserve' on 'ResizeObserver': 1 argument required, but only 0 present.")}if(!isElement(e)){throw new TypeError("Failed to execute 'unobserve' on 'ResizeObserver': parameter 1 is not of type 'Element")}ResizeObserverController.unobserve(this,e)};e.prototype.disconnect=function(){ResizeObserverController.disconnect(this)};e.toString=function(){return"function ResizeObserver () { [polyfill code] }"};return e}();

/***/ })

}]);