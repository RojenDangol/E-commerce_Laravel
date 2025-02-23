@extends('layouts.admin')
@section('content')
<style>
    .repeater-item {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        position: relative;
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
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Color information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{route('admin.colors')}}">
                        <div class="text-tiny">Colors</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">New Color</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('admin.color.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Repeater Section -->
                <div id="repeater" class="sortable-container">
                    
                    <div class="repeater-item row" data-index="0">
                        <div>
                            <span class="repeater-number">1</span>
                            <span class="separator">:::</span>
                        </div>
                        <div class="col-md-4">
                            <label for="title-0" class="form-label">Title</label>
                            <input type="text" id="title-0" name="items[0][title]" class="form-control color-title" placeholder="Color Name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="code-0" class="form-label">Code</label>
                            <input type="text" id="code-0" name="items[0][code]" class="form-control color-code" placeholder="Color Hex Code" required>
                        </div>

                        <!-- Controls -->
                        <div class="repeater-controls col-md-4 mt-5">
                            <button type="button" class="btn-add btn-success">+</button>
                            <button type="button" class="btn-remove btn-danger">-</button>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <span >Note: If hex code does not generate automatically please manually provide the hex code.</span>
                </div>
                <!-- Submit Button -->
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
    let index = 1;

    // Add new repeater item below the current one
    const addRepeaterItem = (currentIndex, currentItem) => {
        const repeater = document.getElementById('repeater');
        const newItem = document.createElement('div');
        newItem.classList.add('repeater-item', 'row');
        newItem.setAttribute('data-index', currentIndex);
        newItem.innerHTML = `
            <div>
                <span class="repeater-number">${currentIndex + 1}</span>
                <span class="separator">:::</span>
            </div>
            <div class="col-md-4">
                <label for="title-${currentIndex}" class="form-label">Title</label>
                <input type="text" id="title-${currentIndex}" name="items[${currentIndex}][title]" class="form-control color-title" placeholder="Color Name" required>
            </div>     
            <div class="col-md-4">
                <label for="code-${currentIndex}" class="form-label">Code</label>
                <input type="text" id="code-${currentIndex}" name="items[${currentIndex}][code]" class="form-control color-code" placeholder="Color Hex Code" required>
            </div> 
            <div class="repeater-controls col-md-4 mt-5">
                <button type="button" class="btn-add btn-success">+</button>
                <button type="button" class="btn-remove btn-danger">-</button>
            </div>
        `;

        repeater.insertBefore(newItem, currentItem.nextSibling);
        setupControls(newItem);
        updateNumbers();
    };

    // Remove a repeater item
    const removeRepeaterItem = (item) => {
        const repeater = document.getElementById('repeater');
        if (repeater.childElementCount > 1) {
            item.remove();
            updateNumbers();
        } else {
            swal({
                    title: "Note!",
                    text: "At least one item is required.",
                    type: "warning",
                    buttons: "OK",
                    confirmButtonCOlor: "#dc3545"
                });
        }
    };

    const updateNumbers = () => {
        document.querySelectorAll('.repeater-item').forEach((item, index) => {
            item.querySelector('.repeater-number').textContent = index + 1;
        });
    };

    const setupControls = (item) => {
        item.querySelector('.btn-add').addEventListener('click', () => {
            addRepeaterItem(index++, item);
        });

        item.querySelector('.btn-remove').addEventListener('click', () => {
            removeRepeaterItem(item);
        });
    };

    document.querySelectorAll('.repeater-item').forEach(setupControls);

    const sortable = new Sortable(document.getElementById('repeater'), {
        handle: '.repeater-item',
        animation: 150,
        onEnd(evt) {
            // Handle the reordering of the repeater fields if necessary
            updateNumbers();
            console.log('Reorder complete');
        }
    });

    // Function to fetch hex code from color name
    const colorDictionary = {
        "amber": "#FFBF00",
        "azure": "#007FFF",
        "beige": "#F5F5DC",
        "black": "#000000",
        "blue": "#0000FF",
        "brown": "#A52A2A",
        "burgundy": "#800020",
        "charcoal": "#36454F",
        "copper": "#B87333",
        "coral": "#FF7F50",
        "cyan": "#00FFFF",
        "darkblue": "#00008B",
        "darkbrown": "#8B4513",
        "darkcyan": "#008B8B",
        "darkgray": "#A9A9A9",
        "darkgreen": "#006400",
        "darklime": "#32CD32",
        "darkmagenta": "#8B008B",
        "darkorange": "#FF8C00",
        "darkpink": "#FF1493",
        "darkpurple": "#800080",
        "darkred": "#8B0000",
        "deepblue": "#00008B",
        "forestgreen": "#228B22",
        "gold": "#FFD700",
        "goldenyellow": "#FFC000",
        "gray": "#808080",
        "greenyellow": "#ADFF2F",
        "indigo": "#4B0082",
        "ivory": "#FFFFF0",
        "khaki": "#F0E68C",
        "lavender": "#E6E6FA",
        "lightpink": "#FFB6C1",
        "lime": "#00FF00",
        "lilac": "#C8A2C8",
        "magenta": "#FF00FF",
        "maroon": "#800000",
        "mauve": "#E0B0FF",
        "midnightblue": "#191970",
        "mintgreen": "#98FB98",
        "navy": "#000080",
        "offwhite": "#FFFFE0",
        "olive": "#808000",
        "olivegreen": "#B5B35C",
        "orange": "#FFA500",
        "pastelyellow": "#FFFAA0",
        "peach": "#FFDAB9",
        "pink": "#FFC0CB",
        "plum": "#8E4585",
        "purple": "#800080",
        "red": "#FF0000",
        "rosegold": "#B76E79",
        "rose": "#FF007F",
        "royalblue": "#4169E1",
        "salmon": "#FA8072",
        "silver": "#C0C0C0",
        "skyblue": "#87CEEB",
        "tan": "#D2B48C",
        "teal": "#008080",
        "turquoise": "#40E0D0",
        "violet": "#EE82EE",
        "white": "#FFFFFF",
        "yellow": "#FFFF00"
        "zinc": "#7B7D7D"
    }


    function updateColorHex(input) {
        const parent = input.closest(".repeater-item");
        const colorInput = parent.querySelector(".color-code");
        const colorName = input.value.trim().toLowerCase();

        // Check in dictionary
        if (colorDictionary[colorName]) {
            colorInput.value = colorDictionary[colorName]; // Set hex code
        } else {
            colorInput.value = ""; // Clear if not found
        }
    }

    // Listen for input on color name fields
    document.addEventListener("input", function(event) {
        if (event.target.matches(".color-title")) {
            updateColorHex(event.target);
        }
    });

</script>
@endpush
