$(".logout-admin").click(() => {
  document.cookie = "adminId=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.location.href = "/login/admin";
});
