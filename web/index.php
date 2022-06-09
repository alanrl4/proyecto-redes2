<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto</title>
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body class="mdc-typography" style="margin: 0; padding: 0;">
    <header class="mdc-top-app-bar mdc-top-app-bar--fixed">
        <div class="mdc-top-app-bar__row">
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                <span class="mdc-top-app-bar__title">Proyecto</span>
            </section>
        </div>
    </header>
    <main class="mdc-top-app-bar--fixed-adjust" style="display: flex; justify-content: space-around;">
        <form method="post" action="./upload.php" enctype="multipart/form-data" style="padding: 4rem;min-width: 500px;">
            <div class="mdc-card mdc-card--outlined" style="padding: 0 1rem;">
                <div class="mdc-card__content">
                    <h5 class="mdc-typography--headline6 mdc-theme--primary">
                        Subir archivo
                    </h5>
                    <label class="mdc-text-field mdc-text-field-1 mdc-text-field--outlined" style="width: 100%;" id="trigger-file">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="file-field">Archivo</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                        <input type="text" class="mdc-text-field__input" aria-labelledby="file-field" id='file-name'>
                    </label>
                    <input type="file" class="mdc-text-field__input" name="archivo" id="archivo" style="display: none;">
                    <?php if (isset($_GET["action"]) && $_GET["action"] == "download" && isset($_GET["err"]) && $_GET["err"] != "0" ) { ?>
                        <div style="padding: 1rem 0;">
                            <span class="mdc-typography--caption mdc-theme--error">
                                Hubo un problema subiendo el archivo
                            </span>
                        </div>
                    <?php } ?>
                </div>
                <div class="mdc-card__actions" style="justify-content: flex-end">
                    <button class="mdc-button mdc-card__action mdc-card__action--button upload-send" type="submit">
                        <div class="mdc-button__ripple"></div>
                        <span class="mdc-button__label" style="text-transform: none;">
                            Cargar archivo
                        </span>
                    </button>
                </div>
            </div>

        </form>
        <form method="post" action="./download.php" style="padding: 4rem;min-width: 500px;">
            <div class="mdc-card mdc-card--outlined" style="padding: 0 1rem">
                <div class="mdc-card__content">
                    <h5 class="mdc-typography--headline6 mdc-theme--primary">
                        Descargar archivo
                    </h5>
                    <label class="mdc-text-field mdc-text-field-2 mdc-text-field--outlined" style="width: 100%;">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="file-field">Nombre de archivo</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                        <input class="mdc-text-field__input" aria-labelledby="file-field" type="text" id="nombre" name="nombre">
                    </label>
                    <?php if (isset($_GET["action"]) && $_GET["action"] == "download" && isset($_GET["err"]) && $_GET["err"] != "0" ) { ?>
                        <div style="padding: 1rem 0;">
                            <span class="mdc-typography--caption mdc-theme--error">
                                No se encontro el archivo que intentas consultar
                            </span>
                        </div>
                    <?php } ?>
                </div>
                <div class="mdc-card__actions" style="justify-content: flex-end">
                    <button class="mdc-button mdc-card__action mdc-card__action--button download-send" type="submit">
                        <div class="mdc-button__ripple"></div>
                        <span class="mdc-button__label" style="text-transform: none;">
                            Consultar
                        </span>
                    </button>
                </div>
            </div>

        </form>
    </main>

    <script>
        (() => {
            mdc.ripple.MDCRipple.attachTo(document.querySelector('.upload-send'));
            mdc.ripple.MDCRipple.attachTo(document.querySelector('.download-send'));
            const topAppBarElement = document.querySelector('.mdc-top-app-bar');
            const topAppBar = new mdc.topAppBar.MDCTopAppBar(topAppBarElement);
            new mdc.textField.MDCTextField(document.querySelector('.mdc-text-field-1'));
            new mdc.textField.MDCTextField(document.querySelector('.mdc-text-field-2'));

            const triggerFile = document.getElementById('trigger-file');
            const inputFile = document.getElementById('archivo');
            const fileName = document.getElementById('file-name');
            triggerFile.addEventListener("click", e => {
                inputFile.click();
            })
            inputFile.addEventListener('change', e => {
                if (inputFile.files && inputFile.files[0]) {
                    fileName.value = inputFile.files[0].name
                }
            })

        })()
    </script>
</body>

</html>