function copyLink() {
    const copyText = document.getElementById("recipeLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // Untuk mendukung mobile
    document.execCommand("copy");
    alert("Tautan berhasil disalin: " + copyText.value);
}