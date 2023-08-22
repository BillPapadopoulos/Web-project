window.onload = function() {
  fetchCategories();
  fetchShops();

};

function fetchCategories() {
  fetch('/web_database/map/report_offer/fetch_categories.php')
      .then(response => response.json())
      .then(data => {
          let categoryDropdown = document.getElementById('categoryDropdown');
          
          data.forEach(category => {
              let option = document.createElement('option');
              option.value = category.category_id;
              option.textContent = category.category_name;
              categoryDropdown.appendChild(option);
          });
      })
      .catch(error => {
          console.error("There was an error fetching the categories:", error);
      });
}

function fetchSubcategories(categoryId) {
  if(categoryId) {
      fetch('/web_database/map/report_offer/fetch_subcategories.php?category_id=' + categoryId)
      .then(response => response.json())
      .then(data => {
          let subcategoriesDropdown = document.getElementById('subcategory');
          subcategoriesDropdown.innerHTML = '<option value="" selected="selected">Choose subcategory</option>';

          data.forEach(subcategory => {
              let option = document.createElement('option');
              option.value = subcategory.subcategory_id;
              option.textContent = subcategory.subcategory_name;
              subcategoriesDropdown.appendChild(option);
          });
      });
  } else {
      document.getElementById('subcategory').innerHTML = '<option value="" selected="selected">Choose subcategory</option>';
  }
}
function fetchProducts(subcategoryId) {
  if(subcategoryId) {
      fetch('/web_database/map/report_offer/fetch_products.php?subcategory_id=' + subcategoryId)
      .then(response => response.json())
      .then(data => {
          let productsDropdown = document.getElementById('product');
          productsDropdown.innerHTML = '<option value="" selected="selected">Choose product</option>';

          data.forEach(product => {
              let option = document.createElement('option');
              option.value = product.product_id;
              option.textContent = product.product_name;
              productsDropdown.appendChild(option);
          });
      });
  } else {
      document.getElementById('product').innerHTML = '<option value="" selected="selected">Choose product</option>';
  }
}

function setSelectedShop() {
    if (selectedShop) {
        var shopDropdown = document.getElementById('shopDropdown');
        shopDropdown.value = selectedShop;
    }
}


function fetchShops() {
    fetch('fetch_shops.php')
        .then(response => response.json())
        .then(data => {
            let dropdown = document.getElementById('shopDropdown');
            dropdown.length = 1;
  
            data.forEach(shop => {
                let option = document.createElement('option');
                option.text = shop.shop_name;
                option.value = shop.shop_id;
                if (shop.shop_id == selectedShopId) {
                    option.selected = true;
                }
                dropdown.add(option);
            });
        })
        .catch(error => {
            console.error('Error fetching shops:', error);
        });
  }
  
