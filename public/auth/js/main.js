function toggleSwap() {
    img = document.getElementById("toggle");
    if (img.src.endsWith("eye-open.png"))
        img.src = "/auth/images/eye-close.png";
    else if (img.src.endsWith("eye-close.png"))
        img.src = "/auth/images/eye-open.png";
}
