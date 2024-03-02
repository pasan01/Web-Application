// JavaScript code to filter items based on filter buttons

document.addEventListener('DOMContentLoaded', function () {
  var filterButtons = document.querySelectorAll('.filter_button button');
  var menuItems = document.querySelectorAll('.menu .itemBox');

  for (var i = 0; i < filterButtons.length; i++) {
    filterButtons[i].addEventListener('click', function () {

      for (var j = 0; j < filterButtons.length; j++) {
        filterButtons[j].classList.remove('filter-active');
      }

      this.classList.add('filter-active');

      var filterName = this.getAttribute('data-name');

      for (var k = 0; k < menuItems.length; k++) {
        if (filterName === 'All_Categories' || menuItems[k].getAttribute('data-name') === filterName) {
          menuItems[k].style.display = 'block';
        } else {
          menuItems[k].style.display = 'none';
        }
      }
    });
  }
});

var basketItems = [];


// addToBasket function
function addToBasket(itemName, itemPrice) {
  var basketItem = {
    name: itemName,
    price: itemPrice,
  };
  basketItems.push(basketItem);
  updateBasket();

  alert(itemName + " added to the basket!");
}

// updateBasket function
function updateBasket() {
  var basketList = document.querySelector(".basket-items");
  basketList.innerHTML = "";

  var totalPrice = 0;
  basketItems.forEach(function (item) {
    var listItem = document.createElement("li");
    listItem.innerText = item.name + " - LKR " + item.price.toFixed(2);
    basketList.appendChild(listItem);
    totalPrice += item.price;
  });

  var totalPriceElement = document.querySelector(".total-price");
  totalPriceElement.innerText = "Total: LKR " + totalPrice.toFixed(2);
}

var addToBasketButtons = document.querySelectorAll(".add-to-basket");
addToBasketButtons.forEach(function (button) {
  button.addEventListener("click", function (e) {
    var itemName = e.target.dataset.item;
    var itemPrice = parseFloat(e.target.dataset.price);
    addToBasket(itemName, itemPrice);
  });
});


