<div class="bg-white py-6">
    <div class="container mx-auto px-4">
        <nav class="flex flex-col md:flex-row md:items-center md:justify-between" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-3">
                @foreach ($items as $item)
                    <li class="flex items-center" @if($item['active'] ?? false) aria-current="page" @endif>
                        @if (!empty($item['url']) && !($item['active'] ?? false))
                            <a href="{{ $item['url'] }}" class="text-gray-700 hover:text-primary flex items-center">
                                @if (!empty($item['icon']))
                                    {!! $item['icon'] !!}
                                @endif
                                {{ $item['label'] }}
                            </a>
                        @else
                            <div class="flex items-center">
                                @if (!empty($item['icon']))
                                    {!! $item['icon'] !!}
                                @endif
                                <span class="ml-1 text-gray-500 md:ml-2">{{ $item['label'] }}</span>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ol>
            @isset($slot)
                <div class="mt-4 md:mt-0 md:ml-6 w-full md:w-auto flex justify-center md:justify-end">
                    {!! $slot !!}
                </div>
            @endisset
        </nav>
    </div>
</div>
