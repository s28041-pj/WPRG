<?php
session_start();
include 'views/header.php';
?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="card" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h2 class="mb-4 text-center">Contact</h2>
            <form id="contactForm" action="send_contact.php" method="POST">
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="name" name="name" class="form-control" required />
                    <label class="form-label" for="name">Name</label>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" required />
                    <label class="form-label" for="email">Email</label>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea id="message" name="message" class="form-control" required></textarea>
                    <label class="form-label" for="message">Message</label>
                </div>
                <button type="submit" class="btn btn-secondary btn-block mb-4">Send</button>
            </form>
        </div>
    </div>
</div>

<div id="confirmationSendPopup" class="confirmation-popup">
    <h3>Message sent successfully!</h3>
    <button onclick="hideConfirmationSendPopup()" class="btn btn-secondary">Close</button>
</div>

<div id="errorPopup" class="error-popup">
    <h3>Messaging sent unsuccessfully!</h3>
    <p>Try again later.</p>
    <button onclick="hideErrorPopup()" class="btn btn-secondary">Close</button>
</div>

<?php include 'views/footer.php'; ?>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => {
                if (response.ok) {
                    document.getElementById('confirmationSendPopup').style.display = 'block';
                    this.reset();
                } else {
                    document.getElementById('errorPopup').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('errorPopup').style.display = 'block';
            });
    });

    function hideConfirmationSendPopup() {
        document.getElementById('confirmationSendPopup').style.display = 'none';
    }

    function hideErrorPopup() {
        document.getElementById('errorPopup').style.display = 'none';
    }
</script>

<style>
    .confirmation-popup, .error-popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .confirmation-popup h3, .error-popup h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .confirmation-popup button, .error-popup button {
        display: block;
        width: 100%;
        padding: 8px 16px;
        margin-top: 10px;
        background-color: #6c757d;
        border: none;
        color: #fff;
    }
</style>