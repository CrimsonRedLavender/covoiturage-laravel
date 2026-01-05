<x-app-layout>
    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <label>Véhicule utilisé</label>
        <select name="vehicle_id" required>
            @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">
                    {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})
                </option>
            @endforeach
        </select>

        <label>Places disponibles</label>
        <input type="number" name="available_seats" min="1" required>

        <label>Commentaire (optionnel)</label>
        <textarea name="comment" rows="3" placeholder="Informations supplémentaires..."></textarea>


        {{-- STOPS --}}

        <h2>Étapes du trajet</h2>

        <table id="stops-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Adresse</th>
                <th>Heure de départ</th>
                <th>Heure d'arrivée</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody id="stops-body">
            {{-- First stop (index 0) --}}
            <tr class="stop-row">
                <td class="stop-order">1</td>

                <td>
                    <input type="text" name="stops[0][address]" required>
                </td>

                <td>
                    <input type="datetime-local" name="stops[0][departure_time]" required>
                </td>

                <td>
                    <input type="datetime-local" name="stops[0][arrival_time]" required>
                </td>

                <td>
                    <button type="button" class="btn-add">+</button>
                    <button type="button" class="btn-remove" disabled>-</button>
                </td>
            </tr>
            </tbody>
        </table>

        <button type="submit" class="btn-primary" style="margin-top:20px;">
            Créer le trajet
        </button>
    </form>

    <script>
        const maxStops = 10;
        const tbody = document.getElementById('stops-body');

        function updateOrders() {
            const rows = document.querySelectorAll('.stop-row');
            rows.forEach((row, index) => {
                row.querySelector('.stop-order').textContent = index + 1;

                // Update input names
                row.querySelectorAll('input').forEach(input => {
                    const field = input.getAttribute('data-field');
                    input.name = `stops[${index}][${field}]`;
                });

                // Disable remove button if only one row
                const removeBtn = row.querySelector('.btn-remove');
                removeBtn.disabled = (rows.length === 1);
            });
        }

        function addStop(afterRow) {
            const rows = document.querySelectorAll('.stop-row');
            if (rows.length >= maxStops) return;

            const newRow = afterRow.cloneNode(true);

            // Clear values
            newRow.querySelectorAll('input').forEach(input => input.value = '');

            // Insert AFTER the clicked row
            afterRow.insertAdjacentElement('afterend', newRow);

            updateOrders();
        }

        function removeStop(row) {
            const rows = document.querySelectorAll('.stop-row');
            if (rows.length === 1) return;

            row.remove();
            updateOrders();
        }

        // Event delegation
        tbody.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-add')) {
                addStop(e.target.closest('.stop-row'));
            }

            if (e.target.classList.contains('btn-remove')) {
                removeStop(e.target.closest('.stop-row'));
            }
        });

        // Add data-field attributes to inputs
        document.querySelectorAll('.stop-row input').forEach(input => {
            const name = input.name;
            const field = name.substring(name.lastIndexOf('[') + 1, name.lastIndexOf(']'));
            input.setAttribute('data-field', field);
        });
    </script>
</x-app-layout>
