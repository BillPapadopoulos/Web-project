window.onload = function() {
  fetchCategories();
  fetchShops();

};

function fetchCategories() {
  fetch('/web_database/map/admin/statistics/fetch_categories.php')
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
      fetch('/web_database/map/admin/statistics/fetch_subcategories.php?category_id=' + categoryId)
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
