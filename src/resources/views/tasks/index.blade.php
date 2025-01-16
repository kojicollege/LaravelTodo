<x-layout.home>
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto py-8">
            <div class="flex gap-8">
                <!-- サイドバー -->
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

                <!-- メインコンテンツ -->
                <div class="w-2/3">
                    <!-- メインコンテンツ用のスペース -->
                </div>
            </div>
        </div>
    </div>
</x-layout.home>
