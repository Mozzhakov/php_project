const deleteBtn = document.getElementById("deleteBtn");

if (deleteBtn) {
  deleteBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (confirm("Are you sure?")) {
      const form = document.createElement("form");
      form.method = "post";
      form.action = deleteBtn.getAttribute("href");
      document.body.appendChild(form);
      form.submit();
    }
  });
}

const publishBtn = document.querySelectorAll("#publishBtn");

for (let i = 0; i < publishBtn.length; i++) {
  publishBtn[i].addEventListener("click", () => {
    const id = publishBtn[i].getAttribute("data-id");
    const formData = new FormData();
    formData.append("id", id);
    const request = new XMLHttpRequest();
    request.open("POST", "/php_project/publish-article.php");
    request.send(formData);
    location.reload();
  });
}
