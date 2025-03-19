@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить нового кота</h2>
        <form action="{{ route('cats.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Имя:</label>
                <input type="text" name="name" class="form-control" placeholder="Введите имя кота" required>
            </div>
            <div class="mb-3">
                <label>Пол:</label>
                <select name="gender" class="form-control" required>
                    <option value="male">Мужской</option>
                    <option value="female">Женский</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Возраст:</label>
                <input type="number" name="age" class="form-control" min="0" placeholder="Введите возраст" required>
            </div>
            <div class="mb-3">
                <label>Мать:</label>
                <select name="mother_id" class="form-control">
                    <option value="">Нет</option>
                    @foreach($allCats->where('gender', 'female') as $mother)
                        <option value="{{ $mother->id }}">{{ $mother->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Отцы (можно выбрать несколько):</label>
                <select name="fathers[]" class="form-control" multiple>
                    @foreach($allCats->where('gender', 'male') as $father)
                        <option value="{{ $father->id }}">{{ $father->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Создать</button>
            <a href="{{ route('cats.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
