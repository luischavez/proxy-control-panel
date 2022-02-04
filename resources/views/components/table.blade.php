<div class="w-full">
    <div class="overflow-hidden border-b border-gray-100 rounded-md shadow-md">
        <table class="w-full">
            <thead class="p-1 text-white bg-gray-400">
                <tr>
                    @foreach ($headers as $key => $header)
                        <th class="px-6 py-2 text-xs text-white">
                            {{ $header }}
                        </th>
                    @endforeach
                    @if (!empty($actions))
                        <th class="px-6 py-2 text-xs text-white">
                            {{ __('pages.tables.actions_header') }}
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($paginator as $model)
                    <tr class="text-center odd:bg-gray-200 hover:bg-gray-300">
                        @foreach ($headers as $key => $header)
                            <td
                                wire:key="{{ \Illuminate\Support\Str::random(10) }}"
                                x-data="{}"
                                class="px-6 py-3 text-sm"
                                x-init="
                                    content = $el.innerHTML.trim();

                                    if (content.startsWith('{') && content.endsWith('}')) {
                                        content = JSON.parse(content);

                                        button = $el.closest('button');

                                        pre = document.createElement('pre');
                                        pre.classList.add('text-left');
                                        pre.innerHTML = prettyPrintJson.toHtml(content);

                                        if (button !== null) {
                                            button.innerHTML = '';
                                            button.appendChild(pre);
                                        } else {
                                            $el.innerHTML = '';
                                            $el.appendChild(pre);
                                        }
                                    }
                                "
                            >
                                @if (isset($cellActions[$key]))
                                    <button class="p-1 text-xs bg-gray-100 rounded-md shadow-md" wire:click="{{ $cellActions[$key] }}({{ $model->id }})">
                                        {{ data_get($model, $key) }}
                                    </button>
                                @else
                                    {{ data_get($model, $key) }}
                                @endif
                            </td>
                        @endforeach
                        @if (!empty($actions))
                            <td class="px-6 py-3 text-sm">
                                <div class="flex justify-center gap-1 text-xs text-white">
                                    @foreach ($actions as $action)
                                        <button
                                            @class([
                                                'flex items-center gap-1 p-1 rounded-md shadow-md',
                                                'bg-blue-500 hover:bg-blue-600 active:bg-blue-700'  => $action['color'] == 'blue',
                                                'bg-red-500 hover:bg-red-600 active:bg-red-700'     => $action['color'] == 'red',
                                            ])
                                            wire:click="{{  $this->getAction($action, $model->id) }}"
                                        >
                                            {!! isset($action['icon']) ? $icons[$action['icon']] : '' !!}
                                            {{ $action['text'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex flex-col my-2">
        {{ $paginator->links() }}
    </div>
</div>
