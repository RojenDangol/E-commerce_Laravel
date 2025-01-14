@extends('layouts.app');
@section('content');
<style>
    .repeater-item {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        position: relative;
    }

    .repeater-item .col-md-4 {
        margin-bottom: 10px;
    }

    .repeater-controls {
        margin-top: 10px;
        display: flex;
        justify-content: flex-start;
        gap: 10px;
    }

    .repeater-controls button {
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 50%;
        font-size: 20px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-add {
        background-color: #28a745;
    }
    .btn-add:hover {
        background-color: #218838;
    }

    .btn-remove {
        background-color: #dc3545;
    }
    .btn-remove:hover {
        background-color: #b02a37;
    }

    /* Ensure input fields have space */
    .repeater-item input,
    .repeater-item textarea {
        width: 100%;
        margin-bottom: 10px;
    }
</style>

<div class="container">
    <h1>Laravel Repeater Field Example</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('repeater.save') }}" enctype="multipart/form-data">
        @csrf

        <!-- Repeater Section -->
        <div id="repeater">
            <div class="repeater-item row">
                <div class="col-md-4">
                    <label for="title-0" class="form-label">Title</label>
                    <input type="text" id="title-0" name="items[0][title]" class="form-control" placeholder="Enter title" required>
                </div>
                <div class="col-md-4">
                    <label for="description-0" class="form-label">Description</label>
                    <textarea id="description-0" name="items[0][description]" class="form-control" placeholder="Enter description"></textarea>
                </div>
                <div class="col-md-4">
                    <label for="image-0" class="form-label">Upload Image</label>
                    <input type="file" id="image-0" name="items[0][image]" class="form-control" accept="image/*">
                </div>
                <div class="repeater-controls">
                    <button type="button" class="btn-add btn-success">+</button>
                    <button type="button" class="btn-remove btn-danger">-</button>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>
   
@endsection

@push('scripts')
<script>
    let index = 1;

    // Add new repeater item below the current one
    const addRepeaterItem = (currentIndex, currentItem) => {
        const repeater = document.getElementById('repeater');
        const newItem = document.createElement('div');
        newItem.classList.add('repeater-item', 'row');
        newItem.innerHTML = `
            <div class="col-md-4">
                <label for="title-${currentIndex}" class="form-label">Title</label>
                <input type="text" id="title-${currentIndex}" name="items[${currentIndex}][title]" class="form-control" placeholder="Enter title" required>
            </div>
            <div class="col-md-4">
                <label for="description-${currentIndex}" class="form-label">Description</label>
                <textarea id="description-${currentIndex}" name="items[${currentIndex}][description]" class="form-control" placeholder="Enter description"></textarea>
            </div>
            <div class="col-md-4">
                <label for="image-${currentIndex}" class="form-label">Upload Image</label>
                <input type="file" id="image-${currentIndex}" name="items[${currentIndex}][image]" class="form-control" accept="image/*">
            </div>
            <div class="repeater-controls col-md-12">
                <button type="button" class="btn-add btn-success">+</button>
                <button type="button" class="btn-remove btn-danger">-</button>
            </div>
        `;

        // Insert the new item directly below the current one
        repeater.insertBefore(newItem, currentItem.nextSibling);
        setupControls(newItem); // Add functionality to new controls
    };

    // Remove a repeater item
    const removeRepeaterItem = (item) => {
        const repeater = document.getElementById('repeater');
        if (repeater.childElementCount > 1) {
            item.remove();
        } else {
            alert('At least one item is required.');
        }
    };

    // Setup controls for add and remove buttons
    const setupControls = (item) => {
        const addButton = item.querySelector('.btn-add');
        const removeButton = item.querySelector('.btn-remove');

        addButton.addEventListener('click', () => {
            addRepeaterItem(index++, item); // Pass the current item to insert below it
        });

        removeButton.addEventListener('click', () => {
            removeRepeaterItem(item);
        });
    };

    // Initialize the first item
    document.querySelectorAll('.repeater-item').forEach((item) => setupControls(item));
</script>

@endpush