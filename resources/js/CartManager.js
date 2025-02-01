function generateCartItemHTML(item) {
  return `
    <div class="p-4 border-b border-gray-200 cart-item" aria-id="${item.id}">
      <div class="flex items-center justify-between">
        <div class="w-1/3 px-1">
          <label>
            <a href="/products/${item.id}" class="text-blue-500 hover:underline" target="_blank">
              ${item.product_name}
            </a>
          </label>
        </div>

        <div class="flex items-center w-1/3 px-1">
          <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l" onclick="CartManager.decreaseQuantity(${item.id})">
            <i class="fa-solid fa-minus"></i>
          </button>
          <input type="number" name="quantity" value="${item.quantity}" class="form-input w-full text-center">
          <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r" onclick="CartManager.increaseQuantity(${item.id})">
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>

        <div class="flex items-center w-1/3 px-1">
          <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l" onclick="CartManager.decreasePrice(${item.id})">
            <i class="fa-solid fa-minus"></i>
          </button>
          <input type="number" name="price" value="${item.price}" class="form-input w-full text-center">
          <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r" onclick="CartManager.increasePrice(${item.id})">
            <i class="fa-solid fa-plus"></i>
          </button>
          <button type="button" class="btn-reset-price bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded" onclick="CartManager.resetPrice(${item.id})">
            <i class="fa-solid fa-sync"></i>
          </button>
        </div>

        <div class="w-1/3 px-1">
          <select name="type" value="${item.type}">
            <option value="box">Carton</option>
            <option value="pack">Pack</option>
            <option value="unit">Unit</option>
          </select>
        </div>

        <div class="w-1/3 px-1">
          <button type="button" class="btn-remove bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="CartManager.remove(${item.id})">
            Delete
          </button>
        </div>
      </div>
    </div>
  `;
}

export default class CartManager {
  static async load() {
    const cart = $("#cart .items");

    if (!cart) {
      CartManager.loadCount();
      return;
    }

    cart.html(
      '<div class="flex justify-center"><i class="fas fa-spinner fa-spin"></i></div>'
    );

    try {
      const response = await axios.get("/cart");
      if (response.data.success) {
        const items = response.data.items;
        const count = items.length;

        if (count === 0)
          cart.html(
            '<div class="flex justify-center"><p class="p-4">Your cart is empty.</p></div>'
          );
        else {
          let cartHtml = "";
          for (const item of items) cartHtml += generateCartItemHTML(item);

          CartManager.loadCount(count);
          cart.html(cartHtml);

          CartManager.calculate();
        }
      } else {
        console.error("CartManager.load Error:", response.data);
        cart.html(
          '<div class="flex justify-center"><p class="p-4">An error occurred while fetching cart items.</p></div>'
        );
      }
    } catch (error) {
      console.error("CartManager.load Error:", error);
      alert("An error occurred while fetching cart items.");
    }
  }

  static async loadCount(count) {
    if (count === undefined)
      try {
        const response = await axios.get("/cart/count");
        count = response.data.count;
      } catch (error) {
        console.error("CartManager.count Error:", error);
        alert("An error occurred while fetching cart count.");
        count = 0;
      }

    if (count === 0) $("#cart-count").addClass("hidden");
    else {
      $("#cart-count").removeClass("hidden");
      $("#cart-count").text(count);
    }
  }

  static async add(
    button,
    quantity = 1,
    // purchase_price = null,
    price = null,
    type = "box"
  ) {
    button = $(button);
    const id = button.closest("tr").attr("rowpk");

    button.prop("disabled", true);
    button.html('<i class="fas fa-spinner fa-spin"></i>');

    try {
      const response = await axios.post(`/cart/${id}`, {
        quantity: quantity,
        // purchase_price: purchase_price,
        price: price,
        type: type,
      });

      if (response.data.success && response.data.item) {
        $("#cart .items")?.append(generateCartItemHTML(response.data.item));

        CartManager.loadCount();

        CartManager.calculate();

        button.attr("onclick", `CartManager.remove(${id})`);
        button.html('<i class="fa-solid fa-check"></i>');
        button.prop("disabled", false);
      } else alert(response.data.message || "Failed to add product to cart.");
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while adding product to cart.");
    }
  }

  static async remove(id) {
    const confirmDelete = confirm("Are you sure you want to delete this item?");
    if (!confirmDelete) return;

    const tableButton = $(
      `#datatable-products-table tr[rowpk="${id}"] .btn-cart`
    );
    const cartButton = $(`#cart .cart-item[aria-id="${id}"] .btn-remove`);

    tableButton.html('<i class="fas fa-spinner fa-spin"></i>');
    tableButton.prop("disabled", true);

    cartButton.html('<i class="fas fa-spinner fa-spin"></i>');
    cartButton.prop("disabled", true);

    try {
      const response = await axios.delete(`/cart/${id}`);
      if (response.data.success) {
        $(`.cart-item[aria-id="${id}"]`)?.remove();

        CartManager.loadCount();

        CartManager.calculate();

        tableButton.attr("onclick", `CartManager.add(this)`);
        tableButton.html('<i class="fa-solid fa-cart-plus"></i>');
        tableButton.prop("disabled", false);

        cartButton.prop("disabled", false);
        cartButton.html("Delete");
      } else alert("Failed to delete item");
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while deleting item from cart.");
    }
  }

  static async clear() {
    const button = $("#cart .btn-clear");
    const tableButtons = $("#datatable-products-table tr .btn-cart");

    button.prop("disabled", true);
    button.html('<i class="fas fa-spinner fa-spin"></i>');

    tableButtons.prop("disabled", true);
    tableButtons.html('<i class="fas fa-spinner fa-spin"></i>');

    try {
      const response = await axios.delete("/cart");
      if (response.data.success) {
        $("#cart .items")?.html(
          "<div class='flex justify-center'><p class='p-4'>Your cart is empty.</p></div>"
        );

        CartManager.loadCount(0);

        CartManager.calculate();

        button.prop("disabled", false);
        button.html("Clear Cart");

        tableButtons.attr("onclick", "CartManager.add(this)");
        tableButtons.html('<i class="fa-solid fa-cart-plus"></i>');
        tableButtons.prop("disabled", false);
      } else alert("Failed to clear cart");
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while clearing cart.");
    }
  }

  static increaseQuantity(id) {
    const input = $(`.cart-item[aria-id="${id}"] input[name="quantity"]`);
    const quantity = parseInt(input.val());
    input.val(quantity + 1);

    CartManager.calculate();
  }

  static decreaseQuantity(id) {
    const input = $(`.cart-item[aria-id="${id}"] input[name="quantity"]`);
    const quantity = parseInt(input.val());
    if (quantity > 1) input.val(quantity - 1);

    CartManager.calculate();
  }

  static increasePrice(id) {
    const input = $(`.cart-item[aria-id="${id}"] input[name="price"]`);
    const price = parseInt(input.val());
    input.val(price + 5);

    CartManager.calculate();
  }

  static decreasePrice(id) {
    const input = $(`.cart-item[aria-id="${id}"] input[name="price"]`);
    const price = parseInt(input.val());
    if (price > 1) input.val(price - 5);

    CartManager.calculate();
  }

  static async resetPrice(id) {
    const button = $(`.cart-item[aria-id="${id}"] .btn-reset-price`);
    const input = $(`.cart-item[aria-id="${id}"] input[name="price"]`);

    button.prop("disabled", true);
    button.html('<i class="fas fa-spinner fa-spin"></i>');
    input.prop("disabled", true);

    try {
      const response = await axios.get(`/products/${id}`);

      if (response.data.success) {
        const product = response.data.product;
        input.val(product.price);

        CartManager.calculate();

        input.prop("disabled", false);
        button.prop("disabled", false);
        button.html('<i class="fa-solid fa-sync"></i>');
      } else alert(response.data.message || "Failed to reset price");
    } catch (error) {
      console.error("CartManager.resetPrice Error:", error);
      alert("An error occurred while resetting price.");
    }
  }

  static get() {
    const items = [];
    const cartItems = $("#cart .cart-item");

    for (const item of cartItems) {
      const id = item.getAttribute("aria-id");
      const quantity = $(item).find("input[name='quantity']").val();
      const price = $(item).find("input[name='price']").val();
      const type = $(item).find("select[name='type']").val();

      items.push({
        id: id,
        quantity: quantity,
        price: price,
        type: type,
      });
    }

    return items;
  }

  static calculate() {
    if (!$("#cart")) return;

    const items = CartManager.get();

    let total = 0;
    let quantity = items.length;
    let totalQuantity = 0;

    for (const item of items) {
      total += item.quantity * item.price;
      totalQuantity += item.quantity / 1;
    }

    $("#cart .cart-quantity").text(`${quantity}`);
    $("#cart .cart-total-quantity").text(totalQuantity);
    $("#cart .cart-total").text(total);
  }

  static loadInput() {
    const items = CartManager.get();

    const input = $('#order-form input[name="products"]');
    input.val(JSON.stringify(items));
  }
}
