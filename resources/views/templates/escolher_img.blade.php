<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<div class="modal fade" id="change_logo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$titulo}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{ $action }}" method="POST" enctype="multipart/form-data" id="cropForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Faça o Upload da Sua Imagem<span
                                        class="text-danger">*</span></label>
                                <input type="file" name="image" id="inputImage"
                                    class="form-control @error('image') is-invalid @enderror">
                                <input id="editimage_user_id" name="user_id" hidden value={{ $user_id }}>

                                <input id="tipo_corte" hidden value="quadrado1">
                                <input id="corte_largura" hidden value="300">
                                <input id="tipo_altura" hidden value="300">
                                <br>
                                <div class="img-container mt-3" style="display:none;">
                                    <img id="cropperImage" class="img-fluid" src="#" alt="Imagem para cortar">
                                </div>
                                <input name="pasta_imagem" id="pasta_imagem" hidden />
                                <input name="imagem_name" id="imagem_name" hidden />
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="cancelButton">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="cropButton" style="display:none;"><i
                                class="mdi mdi-crop"></i> Cortar</button>
                        <button type="submit" class="btn btn-success" id="saveButton" style="display:none;"><i
                                class="mdi mdi-content-save"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .img-container {
        display: flex;
        /* Usar Flexbox para centralização */
        justify-content: center;
        /* Centralizar horizontalmente */
        align-items: center;
        /* Centralizar verticalmente */
        max-width: 100%;
        /* Limite de largura do contêiner */
        max-height: 400px;
        /* Defina um limite de altura */
        overflow: hidden;
        /* Esconder qualquer transbordamento */
        margin: 0 auto;
        /* Centraliza o contêiner na página */
    }

    #cropperImage {
        max-width: 100%;
        /* A imagem não deve exceder a largura do contêiner */
        max-height: 100%;
        /* A imagem não deve exceder a altura do contêiner */
        display: block;
        /* Remover qualquer comportamento de linha */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let cropper;
        const inputImage = document.getElementById('inputImage');
        const cropperImage = document.getElementById('cropperImage');
        const cropButton = document.getElementById('cropButton');
        const saveButton = document.getElementById('saveButton');
        const form = document.getElementById('cropForm');
        const imgContainer = document.querySelector('.img-container');
        const modal = document.getElementById('change_logo');
        const cancelButton = document.getElementById('cancelButton');

 
        function resetCropper() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            cropperImage.src = '';
            imgContainer.style.display = 'none';
            inputImage.value = '';
            saveButton.style.display = 'none';
            cropButton.style.display = 'none'; // Esconde o botão de cortar
        }

        inputImage.addEventListener('change', function (event) {

            const tipoCorte = $("#tipo_corte").val(); // Pode ser 'quadrado', 'retangular', ou 'livre'

           
            // Define o aspectRatio com base no tipo de corte
            let aspectRatio;
            switch (tipoCorte) {
                case 'quadrado':
                    aspectRatio = 1; // Proporção 1:1 para quadrado
                    break;
                case 'retangular':
                    aspectRatio = 30 / 9; // Proporção 16:9 para retangular (ou qualquer outra que desejar)
                    break;
                case 'livre':
                    aspectRatio = NaN; // Sem restrição de proporção
                    break;
                default:
                    aspectRatio = 1; // Padrão é quadrado
            }

            const files = event.target.files;
            const done = function (url) {
                inputImage.value = '';
                cropperImage.src = url;
                imgContainer.style.display = 'block';
                cropButton.style.display = 'inline-block'; // Mostrar o botão "Cortar" quando a imagem é carregada
                cropper = new Cropper(cropperImage, {
                    aspectRatio: aspectRatio, // Aplica o aspecto dinâmico
                    viewMode: 1,
                    autoCropArea: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: true,
                    scalable: true,
                });
            };

            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        cropButton.addEventListener('click', function () {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: $("#corte_largura").val(),
                    height: $("#corte_altura").val()
                });

                cropperImage.src = canvas.toDataURL('image/png');

                cropper.destroy();
                cropperImage.style.display = 'block';

                // Centraliza a imagem cortada ao atualizar
                imgContainer.style.display = 'flex'; // Certifique-se de que o contêiner permaneça flexível
                cropperImage.style.margin = '0 auto'; // Centraliza horizontalmente dentro do contêiner

                canvas.toBlob(function (blob) {
                    const newInput = document.createElement('input');
                    newInput.type = 'hidden';
                    newInput.name = 'croppedImage';
                    newInput.value = URL.createObjectURL(blob);

                    form.appendChild(newInput);

                    saveButton.style.display = 'inline-block';
                    cropButton.style.display = 'none';

                    const file = new File([blob], "cropped_image.png", { type: "image/png" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    inputImage.files = dataTransfer.files;
                });
            }
        });

        modal.addEventListener('hidden.bs.modal', function () {
            resetCropper();
        });

        cancelButton.addEventListener('click', function () {
            resetCropper();
        });
    });
</script>