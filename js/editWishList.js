document.querySelectorAll('.wishlist-action').forEach(item => {
  item.addEventListener('click', function (event) {
    console.log("ok");
    event.preventDefault();
    const productId = this.getAttribute('data-product-id');
    const wishlistId = this.getAttribute('data-wishlist-id');

    const heartIcon = this.querySelector('i');
    if (wishlistId) {
      // If product already in wishlist, disable the icon
      this.setAttribute('disabled', 'true');
    } else {
      // If product not in wishlist, add it and disable the icon
      heartIcon.classList.remove('fa-regular');
      heartIcon.classList.add('fa-solid');
      addToWishlist(productId, this); // Pass 'this' as an additional parameter
    }
  });
});

// Modify the addToWishlist function to disable the icon after adding
function addToWishlist(productID, element) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../ManageWishList/AddToWishList.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  const pID = `productID=${productID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log('Item added to wishlist!');
        element.setAttribute('disabled', 'true'); // Disable the icon
      } else {
        console.error('Failed to add item to wishlist');
      }
    }
  };

  xhr.send(pID);
}
