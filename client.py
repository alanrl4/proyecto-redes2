from math import ceil
import socket
import sys
import os

PORTS = (3000,3000,3000)
IPS = ('10.10.10.4', '20.20.20.2', '30.30.30.2')

SEPARATOR = '<separator>'
BUFFER_SIZE = 500
CLIENT_FOLDER = "client_files"

if (len(sys.argv) < 3):
    print("Missing arguments: client.py OPERATION FILENAME")
    exit()

try:
    os.mkdir(CLIENT_FOLDER)
except:
    pass

filename = sys.argv[2]
operation = sys.argv[1]
conns = (
    socket.socket(socket.AF_INET, socket.SOCK_STREAM),
    socket.socket(socket.AF_INET, socket.SOCK_STREAM),
    socket.socket(socket.AF_INET, socket.SOCK_STREAM)
)

for i in range(3):
    ip = IPS[i]
    port = PORTS[i]
    conns[i].connect((IPS[i], PORTS[i]))
    print(f'Server {ip}:{port} connected')

try:

    if operation == "upload":

        filesize = os.path.getsize(filename)
        chunk_size = ceil(filesize/3)

        with open(filename, 'rb') as f:

            for i in range(3):
                bytes_sent = 0

                conns[i].send(SEPARATOR.join((filename, operation)).encode())
                if conns[i].recv(BUFFER_SIZE) != b'ACK':
                    exit()
                
                while True:
                    cur_chunk_size = BUFFER_SIZE;
                    left_bytes = chunk_size - bytes_sent
                    if BUFFER_SIZE > left_bytes:
                        cur_chunk_size = left_bytes
                    chunk = f.read(cur_chunk_size)
                    if not chunk:
                        break
                    conns[i].sendall(chunk)
                    bytes_sent += cur_chunk_size
                    if chunk_size - bytes_sent <= 0:
                        break
            print("done")
    else:
        n_filename = f'./{CLIENT_FOLDER}/{os.path.basename(filename)}'
        with open(n_filename, 'wb') as f:
            for i in range(3):
                conns[i].send(SEPARATOR.join((filename, operation)).encode())
                if conns[i].recv(BUFFER_SIZE) == b'1':
                    while True:
                        chunk = conns[i].recv(BUFFER_SIZE)
                        if not chunk:
                            break
                        f.write(chunk)
                else:
                    print("File not found")
                    exit()
        print(n_filename)
finally:
    for i in range(i):
        conns[i].close()