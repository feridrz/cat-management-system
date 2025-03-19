@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать кота</h2>
        <form action="{{ route('cats.update', $cat->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Имя:</label>
                <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
            </div>
            <div class="mb-3">
                <label>Пол:</label>
                <select name="gender" class="form-control" required>
                    <option value="male" {{ $cat->gender == 'male' ? 'selected' : '' }}>Мужской</option>
                    <option value="female" {{ $cat->gender == 'female' ? 'selected' : '' }}>Женский</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Возраст:</label>
                <input type="number" name="age" class="form-control" value="{{ $cat->age }}" min="0" required>
            </div>
            <div class="mb-3">
                <label>Мать:</label>
                <select name="mother_id" class="form-control">
                    <option value="">Нет</option>
                    @foreach($allCats->where('gender', 'female') as $mother)
                        <option value="{{ $mother->id }}" {{ $cat->mother_id == $mother->id ? 'selected' : '' }}>
                            {{ $mother->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Отцы (можно выбрать несколько):</label>
                <select name="fathers[]" class="form-control" multiple>
                    @foreach($allCats->where('gender', 'male') as $father)
                        <option value="{{ $father->id }}" {{ $cat->fathers->contains($father->id) ? 'selected' : '' }}>
                            {{ $father->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Обновить</button>
            <a href="{{ route('cats.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
