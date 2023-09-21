function delayPics (picsArray) {
    document.onreadystatechange = function(e) {
        if ("complete" === document.readyState) {
            for (var i = 0; i < picsArray.length; i +=1) {
                picsArray[i].src = picsArray[i].dataset.src;
            }
        }
    };
}

$(document).ready(function(){
    delayPics (document.getElementsByClassName("no-lazy"))
});
