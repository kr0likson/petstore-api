@extends('layout')

@section('content')
    <h1>Add New Pet</h1>
    <form id="add-pet-form">
        @csrf
        <div>
            <label>ID:</label>
            <input type="number" name="id" required>
        </div>
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Category Name:</label>
            <input type="text" name="category" required>
        </div>
        <div>
            <label>Photo URLs (comma separated):</label>
            <input type="text" name="photoUrls" required>
        </div>
        <div>
            <label>Status:</label>
            <select name="status" required>
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>
        </div>
        <button type="submit">Add Pet</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-pet-form').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let photoUrls = form.find('input[name="photoUrls"]').val().split(',').map(url => url.trim());

                let data = {
                    id: form.find('input[name="id"]').val(),
                    name: form.find('input[name="name"]').val(),
                    category: form.find('input[name="category"]').val(),
                    photoUrls: photoUrls,
                    status: form.find('select[name="status"]').val()
                };

                $.ajax({
                    url: '/api/pets',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {
                        alert('Pet added successfully.');
                        window.location.href = `/pet/${response.id}/edit`;
                    },
                    error: function(error) {
                        alert('Failed to add pet.');
                    }
                });
            });
        });
    </script>
@endsection
