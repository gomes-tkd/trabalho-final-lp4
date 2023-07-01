/* atualiza a imagem do preview */

const readImage = (e) => {
    let reader = new FileReader();
    const files = e.target.files;
    const file = files[0];
    reader.readAsDataURL(file);
    reader.onload = function () {
        let img = document.getElementById("preview-image");
        img.src = reader.result;
    };
}

document.getElementById("imagem").addEventListener("change", readImage);
