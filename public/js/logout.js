$(".logout").click((e) => {
  e.preventDefault();
  document.cookie = "userId=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.location.href = "/login";
});
