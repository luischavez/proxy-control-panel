<div class="flex flex-col w-full">
    <x-table
        :headers="[
            'user'              => __('pages.logs.table.user'),
            'loggeable_type'    => __('pages.logs.table.model'),
            'action'            => __('pages.logs.table.action'),
            'diff'              => __('pages.logs.table.data'),
            'created_at'        => __('pages.logs.table.created_at'),
        ]"
        :paginator="$logs"
    />
</div>
