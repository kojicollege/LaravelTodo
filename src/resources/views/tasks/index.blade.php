<x-layout.home>
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto py-8">
            <div class="flex gap-8">
                <div class="w-1/3">
                    <nav class="border rounded-lg shadow bg-white">
                        <div class="bg-gray-200 px-4 py-2 font-semibold rounded-t-lg">フォルダ</div>
                        <div class="p-4">
                            <a href="#"
                                class="block w-full text-center py-2 px-4 border rounded bg-gray-100 hover:bg-gray-200">
                                フォルダを追加する
                            </a>
                        </div>
                        <div class="list-group">
                            <table class="w-full border-collapse table-auto">
                                @foreach($folders as $folder)
                                <tr class="border-b">
                                    <td class="py-2 px-4 text-left">
                                        <a href="{{ route('tasks.index', ['id' => $folder->id]) }}"
                                            class="list-group-item {{ $folder_id === $folder->id ? 'active' : '' }}">
                                            {{ $folder->title }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-4 whitespace-nowrap text-center">
                                        <a href="#" class="text-blue-500 hover:underline">編集</a>
                                    </td>
                                    <td class="py-2 px-4 whitespace-nowrap text-center">
                                        <a href="#" class="text-red-500 hover:underline">削除</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </nav>
                </div>

                <div class="w-2/3 mx-auto">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="bg-gray-200 font-bold px-4 py-2 rounded-t-lg">
                            タスク
                        </div>

                        <div class="p-4">
                            <div class="text-right">
                                <a href="#"
                                    class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded">
                                    タスクを追加する
                                </a>
                            </div>
                        </div>

                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-300">
                                    <th class="text-left px-4 py-2">タイトル</th>
                                    <th class="text-left px-4 py-2">状態</th>
                                    <th class="text-left px-4 py-2">期限</th>
                                    <th class="text-center px-4 py-2">編集</th>
                                    <th class="text-center px-4 py-2">削除</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $task->title }}</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="inline-block px-2 py-1 text-sm font-medium bg-gray-200 rounded {{ $task->status_class }}">
                                            {{ $task->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $task->formatted_due_date }}</td>
                                    <td class="text-center px-4 py-2">
                                        <a href="#" class="text-blue-500 hover:text-blue-700">
                                            編集
                                        </a>
                                    </td>
                                    <td class="text-center px-4 py-2">
                                        <a href="#" class="text-red-500 hover:text-red-700">
                                            削除
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.home>
