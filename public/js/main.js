// to change navbar active status using js
// // *1 get the main nav container and all the nav items
// const nav_container = document.getElementById("nav-container");
// const nav_items = nav_container.getElementsByTagName("li");
// // *2 loop through each item and add active class to current item
// for (let i = 0; i < nav_items.length; i++){
//     nav_items[i].addEventListener("click", (e) => {
//         // *3 remove active status from current item
//         let currentItem = document.getElementsByClassName("active");
//         currentItem[0].className = currentItem[0].className.replace("active", "");
//         // * add the active status to the clicked item
//         this.className += "active";
//     });
// }


// $(document).on('click', '#nav-container li', function (e) {
//     $(this).addClass("active").siblings().removeClass("active");
// })