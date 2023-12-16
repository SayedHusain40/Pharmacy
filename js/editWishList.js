// for delete and add to wish list
document.querySelectorAll('.wishlist-action').forEach(item => {
  item.addEventListener('click', function (event) {
    event.preventDefault();
    const productId = this.getAttribute('data-product-id');
    const wishlistId = this.getAttribute('data-wishlist-id');

    const heartIcon = this.querySelector('i');
    if (heartIcon.classList.contains('fa-regular')) {
      heartIcon.classList.remove('fa-regular');
      heartIcon.classList.add('fa-solid');
      addToWishlist(productId);
    } else {
      heartIcon.classList.remove('fa-solid');
      heartIcon.classList.add('fa-regular');
      removeFromWishlist(wishlistId);
    }
  });
});

// Add function
function addToWishlist(productID) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../ManageWishList/AddToWishList.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  const pID = `productID=${productID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log('Item added to wishlist!');
      } else {
        console.error('Failed to add item to wishlist');
      }
    }
  };

  xhr.send(pID);
}


// Remove function
function removeFromWishlist(wishlistId) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../ManageWishList/DeleteWishList.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  const wID = `WID=${wishlistId}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log('Item removed from wishlist!');
      } else {
        console.error('Failed to remove item from wishlist');
      }
    }
  };

  xhr.send(wID);
}

// for delete and add to wish list