@extends('cms.layouts.master')

@section('content')
    <div class="container">
        <h1>Category List</h1>

        <ul>
            @foreach($categories as $category)
                <li>
                    {{ $category->name }}
                    @if($category->allChildren)
                        <ul>
                            @foreach ($category->allChildren as $subcategory)
                            <li>
                                {{ $subcategory->name }}

                                @if($subcategory->allChildren)
                                    <ul>
                                        @foreach ($subcategory->allChildren as $child)
                                            <li>
                                                {{ $child->name }}

                                                @if($child->allChildren)
                                                    <ul>
                                                        @foreach ($child->allChildren as $subChild)
                                                            <li>
                                                                {{ $subChild->name }}<br>

                                                                @if($subChild->allChildren)
                                                                    <ul>
                                                                        @foreach ($subChild->allChildren as $subChildCategory)
                                                                            <li>
                                                                                {{ $subChildCategory->name }}

                                                                                @if($subChildCategory->allChildren)
                                                                                    <ul>
                                                                                        @foreach ($subChildCategory->allChildren as $lastChild)
                                                                                            <li>
                                                                                                {{ $lastChild->name }}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection

