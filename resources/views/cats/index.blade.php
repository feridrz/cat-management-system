@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('cats.create') }}" class="btn btn-primary">Добавить кота</a>

            <div class="d-flex gap-2">
                <label for="filterGender" class="mt-2">Пол:</label>
                <select id="filterGender" class="form-control" style="width: 150px;">
                    <option value="">Все</option>
                    <option value="male">Мужской</option>
                    <option value="female">Женский</option>
                </select>

                <label for="filterAge" class="mt-2">Возраст:</label>
                <input type="number" id="filterAge" class="form-control" placeholder="Введите возраст" style="width: 160px;">

                <button id="filterButton" class="btn btn-primary">Применить</button>
                <button id="resetButton" class="btn btn-secondary">Сбросить</button>
            </div>
        </div>

        <table id="catsTable" class="table table-bordered">
            <thead>
            <tr>
                <th>Кличка</th>
                <th>Пол</th>
                <th>Возраст</th>
                <th>Мать</th>
                <th>Отцы</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#catsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('cats.index') }}",
                    data: function (d) {
                        d.gender = $('#filterGender').val();
                        d.age = $('#filterAge').val();
                    }
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'gender', name: 'gender' },
                    { data: 'age', name: 'age' },
                    { data: 'mother', name: 'mother' },
                    { data: 'fathers', name: 'fathers' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            // Filter Button Click Event
            $('#filterButton').click(function() {
                table.draw();
            });

            // Reset Filters
            $('#resetButton').click(function() {
                $('#filterGender').val('');
                $('#filterAge').val('');
                table.draw();
            });
        });
    </script>

@endsection
