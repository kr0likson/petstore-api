@if($pets->isEmpty())
    <p>No pets available.</p>
@else
    <ul class="pets-list">
        @foreach($pets as $pet)
            <li class="pet-item">
                @if(!empty($pet['photoUrls']) && !empty($pet['photoUrls'][0]))
                    <img src="{{ $pet['photoUrls'][0] }}" alt="{{ $pet['name'] ?? 'No name' }}" class="pet-photo">
                @else
                    <img src="default-placeholder.png" alt="No image available" class="pet-photo">
                @endif
                <div class="pet-details">
                    @if(!empty($pet['name']))
                        <h3>{{ $pet['name'] }}</h3>
                    @endif
                    @if(!empty($pet['status']))
                        <p>Status: {{ $pet['status'] }}</p>
                    @endif
                    <a href="/pet/{{ $pet['id'] }}/edit">Edit</a>
                    <form method="POST" action="/api/pets/{{ $pet['id'] }}" style="display:inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endif

<style>
    .pets-list {
        list-style-type: none;
        padding: 0;
    }
    .pet-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .pet-photo {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-right: 20px;
    }
    .pet-details {
        flex: 1;
    }
</style>
