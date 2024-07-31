@extends('layout')

@section('content')
    <h1>Edit Pet</h1>
    <form id="edit-pet-form">
        @csrf
        @method('PUT')
        <div>
            <label>Name:</label>
            <input type="text" name="name" id="pet-name" required>
        </div>
        <div>
            <label>Category Name:</label>
            <input type="text" name="category" id="pet-category-name" required>
        </div>
        <div>
            <label>Status:</label>
            <select name="status" id="pet-status" required>
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>
        </div>
        <div>
            <label>Photo URLs (comma-separated):</label>
            <input type="text" name="photoUrls" id="pet-photo-urls">
        </div>
        <button type="submit">Update Pet</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let petId = {{ $id }};

            $.ajax({
                url: `/api/pets/${petId}`,
                method: 'GET',
                success: function(data) {
                    $('#pet-name').val(data.name);
                    $('#pet-category-name').val(data.category.name);
                    $('#pet-status').val(data.status);
                    $('#pet-photo-urls').val(data.photoUrls ? data.photoUrls.join(',') : '');
                },
                error: function() {
                    alert('Failed to fetch pet details.');
                }
            });

            $('#edit-pet-form').submit(function(e) {
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
                    url: `/api/pets/${petId}`,
                    method: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function() {
                        alert('Pet updated successfully.');
                        window.location.href = `/pet/${response.id}/edit`;
                    },
                    error: function() {
                        alert('Failed to update pet.');
                    }
                });
            });
        });
    </script>
@endsection