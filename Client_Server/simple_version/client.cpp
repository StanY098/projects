#include <iostream>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdlib.h>
#include <unistd.h>
#include <netdb.h>

using namespace std;

int main()
{
    int client;
    int portNum = 2202;
    int bufsize = 1024;
    char buffer[bufsize];
    char ip[] = "127.0.0.1";
    struct sockaddr_in server_addr;
    client = socket(AF_INET, SOCK_STREAM, 0);
    if (client < 0)
    {
        cout << "Error establishing socket" << endl;
        exit(1);
    }
    cout << "=> Socket client has been created" << endl;
    server_addr.sin_family = AF_INET;
    cout << "=> Connection to the ip address: ";
    cin >> ip;
    cout << "=> Connection to the server port number: ";
    cin >> portNum;
    server_addr.sin_addr.s_addr = inet_addr((char*)ip);
    server_addr.sin_port = htons(portNum);
    if (connect(client,(struct sockaddr *)&server_addr, sizeof(server_addr)) < 0){
      cout << "=> Error connection to the server ipaddress: " << ip << " and port number: " << portNum << endl;
    }
    cout << "=> Awaiting confirmation from the server..." << endl;
    recv(client, buffer, bufsize, 0);
    cout << buffer << endl;
    cout << "=> Connection confirmed, you are good to go" << endl;
    cout << "=> Enter # to end the connection\n" << endl;
    cout << "~File Name: ";
    cin >> buffer;
    if(buffer[0] == '#'){
      cout << "Connection terminated." << endl;
      close(client);
      return 0;
    }
    send(client, buffer, bufsize, 0);
    recv(client, buffer, bufsize, 0);
    cout << "~" << buffer << endl;
    recv(client, buffer, bufsize, 0);
    while(buffer[0] != 'e'){
      cout << "~" << buffer << endl;
      recv(client, buffer, bufsize, 0);
    }
    cout << "Connection terminated." << endl;
    close(client);
    return 0;
}
