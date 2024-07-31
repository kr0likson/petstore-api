@extends('layout')

@section('content')
    <h1>Pets list</h1>
    <a href="/pet/create">Add New Pet</a>
    
    <div>
        <label for="status">Filter by status:</label>
        <select id="status" name="status">
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select>
    </div>

    <div id="pets-list-container"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchPets(status) {
            $.ajax({
                url: '/api/pets',
                method: 'GET',
                data: { status: status },
                success: function(data) {
                    $('#pets-list-container').html(data);
                },
                error: function(error) {
                    alert('Failed to fetch pets.');
                }
            });
        }

        $(document).ready(function() {
            let initialStatus = $('#status').val();
            fetchPets(initialStatus);

            $('#status').change(function() {
                let selectedStatus = $(this).val();
                fetchPets(selectedStatus);
            });

            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'DELETE',
                    data: form.serialize(),
                    success: function() {
                        form.closest('li').remove();
                        alert('Pet deleted successfully.');
                    },
                    error: function(error) {
                        alert('Failed to delete pet.');
                    }
                });
            });
        });
    </script>
@endsection