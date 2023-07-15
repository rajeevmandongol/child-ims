@extends('layouts.master')

@section('content')
    @php
        // Initialize the rowCount variable
        $rowCount = 0;
        
        // Variable to represent the indicator symbol for required fields
        $requiredFlag = "<span class='required'>*</span>";
    @endphp

    @if (session('status') && session('status.success'))
        <script>
            // Display an alert with the session status message
            alert("{{ session('status.message') }}");
        </script>
    @endif

    {{-- Check if old function is not null and count is greater than 0 --}}
    {{-- If count is greater than 0, the form contains some errors --}}
    @if (!is_null(old('child_first_name')) && count(old('child_first_name')) > 0)
        @php
            // Get the count of the 'id' field or set it to 1
            $idCount = !is_null(old('id')) ? count(old('id')) : 1;
        @endphp

        @for ($rowCount = 0; $rowCount < $idCount; $rowCount++)
            <form id="delete-form-{{ old('id.' . $rowCount) }}" action="{{ url('url/', old('id.' . $rowCount)) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endfor
        <form action="/" method="post" class="of-scroll">
            @csrf
            <div class="button-group">
                <button onclick="addNewRow(event)" class="btn btn-primary">Add New</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            <table id="table">
                <thead>
                    <tr>
                        <th>Action</th>
                        @foreach ($fieldTitles as $fieldTitle)
                            <th>{{ $fieldTitle }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @for ($rowCount = 0; $rowCount < count(old('child_first_name')); $rowCount++)
                        <tr>
                            <input type="hidden" name="id[{{ $rowCount }}]" value="{{ old('id.' . $rowCount) }}">
                            <td>
                                @php
                                    $id = old('id.' . $rowCount) != null ? old('id.' . $rowCount) : null;
                                @endphp
                                <a href="{{ url('children/' . old('id.' . $rowCount)) }}"
                                    onclick="deleteChildRecord(event, {{ old('id.' . $rowCount) }})"
                                    class="btn {{ is_null($id) ? 'btn-secondary' : 'btn-danger' }} {{ is_null($id) ? 'disabled' : '' }}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>

                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                @error('child_first_name.' . $rowCount)
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                                <input type="text" name="child_first_name[{{ $rowCount }}]"
                                    placeholder="Child First Name" value="{{ old('child_first_name.' . $rowCount) }}">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                @error('child_middle_name.' . $rowCount)
                                    <span class="error-text">{{ $message }}</span>
                                @enderror

                                <input type="text" name="child_middle_name[{{ $rowCount }}]"
                                    placeholder="Child Middle Name" value="{{ old('child_middle_name.' . $rowCount) }}"
                                    required="required">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                @error('child_last_name.' . $rowCount)
                                    <span class="error-text">{{ $message }}</span>
                                @enderror

                                <input type="text" name="child_last_name[{{ $rowCount }}]"
                                    placeholder="Child Last Name" value="{{ old('child_last_name.' . $rowCount) }}"
                                    required="required">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                @error('child_age.' . $rowCount)
                                    <span class="error-text">{{ $message }}</span>
                                @enderror

                                <input type="text" name="child_age[{{ $rowCount }}]" placeholder="Child Age"
                                    value="{{ old('child_age.' . $rowCount) }}" required="required">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                <select name="child_gender[{{ $rowCount }}]" required="required">
                                    <option value="female"
                                        {{ old('child_gender.' . $rowCount) === 'female' ? 'selected' : '' }}>
                                        Female</option>
                                    <option value="male"
                                        {{ old('child_gender.' . $rowCount) === 'male' ? 'selected' : '' }}>
                                        Male</option>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" name="child_different_address[{{ $rowCount }}]"
                                    id="child_different_address[{{ $rowCount }}]" onclick="toggleChildAddress(this)"
                                    {{ old('child_different_address.' . $rowCount) === 'on' ? 'checked' : '' }}>
                                <label for="child_different_address[{{ $rowCount }}]">
                                    Different Address?
                                </label>
                            </td>
                            <td>
                                <input type="text" name="child_address[{{ $rowCount }}]" placeholder="Child Address"
                                    value="{{ old('child_address.' . $rowCount) }}"
                                    {{ is_null(old('child_address.' . $rowCount)) ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <input type="text" name="child_city[{{ $rowCount }}]" placeholder="Child City"
                                    value="{{ old('child_city.' . $rowCount) }}"
                                    {{ is_null(old('child_city.' . $rowCount)) ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <input type="text" name="child_state[{{ $rowCount }}]" placeholder="Child State"
                                    value="{{ old('child_state.' . $rowCount) }}"
                                    {{ is_null(old('child_state.' . $rowCount)) ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <select name="child_country[{{ $rowCount }}]"
                                    {{ is_null(old('child_country.' . $rowCount)) ? 'disabled' : '' }}>
                                    <option
                                        value="us"{{ old('child_country.' . $rowCount) === 'us' ? 'selected' : '' }}>
                                        United
                                        States</option>
                                    <option
                                        value="np"{{ old('child_country.' . $rowCount) === 'np' ? 'selected' : '' }}>
                                        Nepal
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="child_zip_code[{{ $rowCount }}]"
                                    placeholder="Child Zip Code" value="{{ old('child_zip_code.' . $rowCount) }}"
                                    {{ is_null(old('child_zip_code.' . $rowCount)) ? 'disabled' : '' }}>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </form>
    @endif

    {{-- Check if the old function is null or not --}}
    @if (is_null(old('child_first_name')))
        @foreach ($children as $child)
            <form id="delete-form-{{ $child->id }}" action="{{ route('children.destroy', $child->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
        <form action="/" method="post" class="of-scroll">
            @csrf
            <div class="button-group">
                <button onclick="addNewRow(event)" class="btn btn-primary">Add New</button>

                <button type="submit" class="btn btn-success">Save</button>
            </div>
            <table id="table">
                <thead>
                    <tr>
                        <th>Action</th>
                        @foreach ($fieldTitles as $fieldTitle)
                            <th>{{ $fieldTitle }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @foreach ($children as $child)
                        <tr>
                            <input type="hidden" name="id[{{ $rowCount }}]" value="{{ $child->id }}">
                            <td>
                                <a href="{{ route('children.destroy', $child->id) }}"
                                    onclick="deleteChildRecord(event, {{ $child->id }})" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>

                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                <input type="text" name="child_first_name[{{ $rowCount }}]"
                                    placeholder="Child First Name" value="{{ $child->child_first_name }}">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                <input type="text" name="child_middle_name[{{ $rowCount }}]"
                                    placeholder="Child Middle Name" value="{{ $child->child_middle_name }}"
                                    required="required">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                <input type="text" name="child_last_name[{{ $rowCount }}]"
                                    placeholder="Child Last Name" value="{{ $child->child_last_name }}"
                                    required="required">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                <input type="text" name="child_age[{{ $rowCount }}]" placeholder="Child Age"
                                    value="{{ $child->child_age }}" required="required">
                            </td>
                            <td>
                                {!! $requiredFlag !!}
                                <select name="child_gender[{{ $rowCount }}]" required="required">
                                    <option value="female" {{ $child->child_gender === 'female' ? 'selected' : '' }}>
                                        Female</option>
                                    <option value="male" {{ $child->child_gender === 'male' ? 'selected' : '' }}>
                                        Male</option>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" name="child_different_address[{{ $rowCount }}]"
                                    id="child_different_address[{{ $rowCount }}]" onclick="toggleChildAddress(this)"
                                    {{ $child->child_different_address === 1 ? 'checked' : '' }}>
                                <label for="child_different_address[{{ $rowCount }}]">
                                    Different Address?
                                </label>
                            </td>
                            <td>
                                <input type="text" name="child_address[{{ $rowCount }}]"
                                    placeholder="Child Address" value="{{ $child->child_address }}"
                                    {{ is_null($child->child_address) ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <input type="text" name="child_city[{{ $rowCount }}]" placeholder="Child City"
                                    value="{{ $child->child_city }}" {{ is_null($child->child_city) ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <input type="text" name="child_state[{{ $rowCount }}]" placeholder="Child State"
                                    value="{{ $child->child_state }}"
                                    {{ is_null($child->child_state) ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <select name="child_country[{{ $rowCount }}]"
                                    {{ is_null($child->child_country) ? 'disabled' : '' }}>
                                    <option value="us"{{ $child->child_country === 'us' ? 'selected' : '' }}>
                                        United
                                        States</option>
                                    <option value="np"{{ $child->child_country === 'np' ? 'selected' : '' }}>
                                        Nepal
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="child_zip_code[{{ $rowCount }}]"
                                    placeholder="Child Zip Code" value="{{ $child->child_zip_code }}"
                                    {{ is_null($child->child_zip_code) ? 'disabled' : '' }}>
                            </td>
                        </tr>

                        @php
                            $rowCount++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </form>
    @endif
@endsection
