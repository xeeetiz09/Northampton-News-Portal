function adminHeadingChange(){
    var hd = document.getElementById('heading');
    if (hd.innerHTML == "Admin Registered Successfully!"){
        setTimeout(function(){hd.style.opacity = 0.8}, 2000);
        setTimeout(function(){hd.style.opacity = 0.6}, 2250);
        setTimeout(function(){hd.style.opacity = 0.4}, 2500);
        setTimeout(function(){hd.firstChild.nodeValue = "Add New Admin"}, 2500);
        setTimeout(function(){hd.style.opacity = 0.6}, 2750);
        setTimeout(function(){hd.style.opacity = 0.8}, 3000);
        setTimeout(function(){hd.style.opacity = 1}, 3250);
    }
    else if(hd.innerHTML == "Article Posted Successfully!"){
        setTimeout(function(){hd.style.opacity = 0.8}, 2000);
        setTimeout(function(){hd.style.opacity = 0.6}, 2250);
        setTimeout(function(){hd.style.opacity = 0.4}, 2500);
        setTimeout(function(){hd.firstChild.nodeValue = "Add New Article"}, 2500);
        setTimeout(function(){hd.style.opacity = 0.4}, 2750);
        setTimeout(function(){hd.style.opacity = 0.6}, 3000);
        setTimeout(function(){hd.style.opacity = 0.8}, 3250);
        setTimeout(function(){hd.style.opacity = 1}, 3500);
    }

    else if(hd.innerHTML == "Category Added Successfully!"){
        setTimeout(function(){hd.style.opacity = 0.8}, 2000);
        setTimeout(function(){hd.style.opacity = 0.6}, 2250);
        setTimeout(function(){hd.style.opacity = 0.4}, 2500);
        setTimeout(function(){hd.firstChild.nodeValue = "Add New Category"}, 2500);
        setTimeout(function(){hd.style.opacity = 0.4}, 2750);
        setTimeout(function(){hd.style.opacity = 0.6}, 3000);
        setTimeout(function(){hd.style.opacity = 0.8}, 3250);
        setTimeout(function(){hd.style.opacity = 1}, 3500);
    }
}

document.addEventListener('DOMContentLoaded', adminHeadingChange);