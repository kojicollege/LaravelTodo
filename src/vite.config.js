import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: "localhost", // ホスト名を明示的に指定
            protocol: "ws", // WebSocket プロトコルの使用
            port: 5173, // デフォルトポート（Viteがリッスンするポート）
        },
        watch: {
            usePolling: true, // ポーリングを有効にして、ファイル変更を監視
        },
        host: "0.0.0.0", // Dockerコンテナで外部からアクセスできるように設定
        port: 5173, // 使用するポート番号
    },
});
