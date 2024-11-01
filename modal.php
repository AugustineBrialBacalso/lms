<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal to Textbox Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Parent Page</h2>
    <input type="text" id="myTextbox" class="form-control" placeholder="Data from modal will appear here">
    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#myModal">Open Modal</button>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="modalInput" class="form-control" placeholder="Type something...">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitModalData">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#submitModalData').click(function() {
        var inputData = $('#modalInput').val();
        $('#myTextbox').val(inputData); // Set the textbox value to the modal input
        $('#myModal').modal('hide'); // Hide the modal
    });
});
</script>

</body>
</html>