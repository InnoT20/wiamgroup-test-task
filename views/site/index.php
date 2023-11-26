<?php

/** @var yii\web\View $this */

$this->title = 'Wiamgroup - Test TASK';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-12">

                <div style="margin-bottom: 20px" id="image-here">
                </div>

                <p>
                    <button class="btn btn-outline-secondary" disabled id="apply">Apply</button>
                </p>
                <p>
                    <button class="btn btn-outline-secondary" disabled id="reject">Reject</button>
                </p>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

<script>
    const applyButton = document.getElementById('apply');
    const rejectButton = document.getElementById('reject');

    function loadImage() {
        axios.get('/image', {responseType: 'blob'}).then(res => {
            console.log(res.headers['x-image-id']);
            const imageDiv = document.getElementById("image-here");
            while (imageDiv.firstChild) {
                imageDiv.removeChild(imageDiv.lastChild);
            }

            let img = document.createElement("img");
            img.id = 'random-image';
            img.src = URL.createObjectURL(res.data);
            img.setAttribute('data-id', res.headers['x-image-id']);
            imageDiv.appendChild(img);

            applyButton.disabled = false;
            rejectButton.disabled = false;
        });
    }

    function getImageXId() {
        return document.getElementById('random-image').getAttribute('data-id');
    }

    function sendDecision(id, status) {
        applyButton.disabled = true;
        rejectButton.disabled = true;

        axios.post('/image/resolve', {
            id: id,
            status: status
        }).then(res => {
            loadImage();
        });
    }

    applyButton.onclick = function () {
        sendDecision(getImageXId(), 'apply');
    };

    rejectButton.onclick = function () {
        sendDecision(getImageXId(), 'reject');
    };

    loadImage();
</script>