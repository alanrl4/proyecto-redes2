
import socket
import sys
import os
import threading


IP = 'localhost'
SEPARATOR = '<separator>'
BUFFER_SIZE = 500

if (len(sys.argv) < 3):
    print("Missing arguments: server.py PORT FOLDER")
    exit()

PORT = int(sys.argv[1])
FILES_FOLDER = sys.argv[2]
try:
    os.mkdir(FILES_FOLDER)
except:
    pass

def handler(conn: socket.socket, client_address: tuple):
    try:
        
        d = conn.recv(BUFFER_SIZE).decode()
        filename, operation = d.split(SEPARATOR)

        filename = f'./{FILES_FOLDER}/{os.path.basename(filename)}.chunk'

        if operation == "upload":
            conn.send(b'ACK')
            with open(filename, 'wb') as f:
                while True:
                    d = conn.recv(BUFFER_SIZE)
                    if not d:
                        break;
                    f.write(d)
        else:
            if os.path.exists(filename):
                conn.send(b'1')
                with open(filename, 'rb') as f:
                    while True:
                        chunk = f.read(BUFFER_SIZE)
                        if not chunk:
                            break
                        conn.sendall(chunk)
                print(f'{filename} sent')
            else:
                conn.send(b'0')
                print(f'{filename} not found')
    finally:
        conn.close()

sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_address = (IP, PORT)
sock.bind(server_address)
sock.listen(10);

print('Server listen on {}:{}'.format(*server_address))
while True:
    conn, client_address = sock.accept()
    threading.Thread(target=handler, args=(conn, client_address)).start()