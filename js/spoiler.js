function performSpoiler(obj)
{
    var inner = obj.parentNode.getElementsByTagName("div")[0];
    var symbol = obj.parentNode.getElementsByTagName("span")[0];
    if (inner.style.display == "none")
    {
        symbol.innerHTML = '&#9660;';
        //$(inner).fadeIn(1000);
        $(inner).slideDown(200);
    }
    else
    {
        symbol.innerHTML = '&#9658;';
        //$(inner).fadeOut(500); 
        $(inner).slideUp(200); 
    }
}