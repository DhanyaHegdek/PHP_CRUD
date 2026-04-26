const BASE = "http://localhost/PHP/public";
const API = BASE + "/api/products";
const LOGIN_API = BASE + "/api/login";

//  Get headers with token
function getHeaders() {
  const token = localStorage.getItem("token");

  if (!token) {
    window.location.href = BASE + "/login";
    throw new Error("No token");
  }

  return {
    "Content-Type": "application/json",
    Authorization: "Bearer " + token,
  };
}

// 🔐 LOGIN
async function login() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const res = await fetch(LOGIN_API, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username, password }),
  });

  const data = await res.json();

  if (!res.ok) {
    alert("Login failed");
    return;
  }

  localStorage.setItem("token", data.token);

  window.location.href = BASE + "/products";
}

// 📦 LOAD PRODUCTS
async function loadProducts() {
  try {
    const res = await fetch(API, {
      headers: getHeaders(),
    });

    if (!res.ok) throw new Error("Unauthorized");

    const result = await res.json();
    const products = result.data; //  API returns {data: []})

    const list = document.getElementById("productList");
    list.innerHTML = "";

    products.forEach((p) => {
      const li = document.createElement("li");

      li.innerHTML = `
        ${p.name}
        <button onclick="editProduct(${p.id}, \`${p.name}\`)">Edit</button>
        <button onclick="deleteProduct(${p.id})">Delete</button>
      `;

      list.appendChild(li);
    });
  } catch (err) {
    alert("Session expired");
    localStorage.removeItem("token");
    window.location.href = BASE + "/login";
  }
}

//  ADD PRODUCT
let isAdding = false;

async function addProduct() {
  if (isAdding) return;

  const name = document.getElementById("name").value.trim();

  if (!name) {
    alert("Product name required");
    return;
  }

  isAdding = true;

  try {
    await fetch(API, {
      method: "POST",
      headers: getHeaders(),
      body: JSON.stringify({ name }),
    });

    document.getElementById("name").value = "";
    loadProducts();
  } finally {
    isAdding = false;
  }
}

//  DELETE PRODUCT
async function deleteProduct(id) {
  if (!confirm("Delete this product?")) return;

  await fetch(`${API}/${id}`, {
    method: "DELETE",
    headers: getHeaders(),
  });

  loadProducts();
}

//  UPDATE PRODUCT
async function editProduct(id, oldName) {
  const newName = prompt("Edit product name:", oldName);

  if (!newName) return;

  await fetch(API, {
    method: "PATCH",
    headers: getHeaders(),
    body: JSON.stringify({ id, name: newName }),
  });

  loadProducts();
}

//  INITIAL LOAD
window.onload = () => {
  const isLoginPage = window.location.pathname.includes("/login");
  const token = localStorage.getItem("token");

  // If user is on login page → do nothing
  if (isLoginPage) return;

  // If not logged in → redirect
  if (!token) {
    window.location.href = BASE + "/login";
    return;
  }

  loadProducts();
};

//  LOGOUT
function logout() {
  localStorage.removeItem("token");
  window.location.href = BASE + "/login";
}
