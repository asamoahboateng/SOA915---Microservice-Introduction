import http.server
import socketserver
import os

PORT = 8000
STATIC_DIR = "static"

class CustomHandler(http.server.SimpleHTTPRequestHandler):
    def do_GET(self):
        # Map root path to index.html
        if self.path == "/":
            self.path = "/index.html"
        # If no extension is provided, assume it's an .html file
        elif not os.path.splitext(self.path)[1]:
            possible_html = os.path.join(STATIC_DIR, self.path.strip("/") + ".html")
            if os.path.isfile(possible_html):
                self.path += ".html"

        return super().do_GET()

    def translate_path(self, path):
        # Restrict access to only the static directory
        root = os.path.abspath(STATIC_DIR)
        # Remove query parameters or fragments
        path = path.split("?", 1)[0].split("#", 1)[0]
        # Normalize path and join it with the static directory
        requested = os.path.normpath(path.lstrip("/"))
        return os.path.join(root, requested)

if __name__ == "__main__":
    with socketserver.TCPServer(("", PORT), CustomHandler) as httpd:
        print(f"🚀 Serving on http://0.0.0.0:{PORT}")
        httpd.serve_forever()
