#include <stdio.h>
#include <stdlib.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <string.h>
#include <ctype.h>
#include <errno.h>
#include <dirent.h>
#include <unistd.h>
#include <stdbool.h>
#include <fcntl.h>

//declare functions
int response(char* firstArgument, char* argumentLine[], bool redirect);
int Empty();
void Echo();
int Exit();
void Ls();
void Cd();
void Mkdir();
void Rmdir();
void ErrorMessage();
void FileProgram(char* arugementLine[], bool redirect);
int getArrowIndex(char** argumentLine);

//main function
int main(){
  int maxSize = 1000;
  char* argumentLine[maxSize];
  char* direct = ">";
  char* execute = "./";
  while(1){
    bool redirect = false;
    //stdin the argumentLine
    char inputString[maxSize];
    //update the current directory
    char currentPath[maxSize];
    getcwd(currentPath, maxSize);
    printf("stanley@stanley-VirtualBox:~%s$ ", currentPath);
    fgets(inputString, maxSize, stdin);
    //split the line argument
    int argumentCounter = 0;
    char* edittedInputString = strtok(inputString, "\n");
    char* nextArgument = strtok(edittedInputString," ");
    while(nextArgument != NULL){
      //check if redirection
      if(strcmp(nextArgument, direct) == 0){
        redirect = true;
      }
      argumentLine[argumentCounter++] = nextArgument;
      nextArgument = strtok(NULL, " ");
    }
    argumentLine[argumentCounter] = 0;
    //make a response from user command input
    int returnValue = response(argumentLine[0], argumentLine, redirect);
    if(returnValue == 1){
      return 1;
    }
    //clear argv arguments
    int counter = 0;
    while(argumentLine[counter] != 0){
      argumentLine[counter++] = 0;
    }
  }
  return 0;
}
//define response function
int response(char* firstArgument, char* argumentLine[], bool redirect){
  char* echo = "echo";
  char* exiT = "exit";
  char* ls = "ls";
  char* cd = "cd";
  char* mkdir = "mkdir";
  char* rmdir = "rmdir";
  char* empty = "\n";
  char* execute = "./";
  char* cat = "cat";
  //check if empty
  if(firstArgument == 0){
    return Empty();
  }
  //check if echo
  else if(strcmp(firstArgument,echo) == 0){
    Echo(argumentLine);
  }
  //check if exit
  else if(strcmp(firstArgument,exiT) == 0){
    return Exit();
  }
  //check if ls
  else if(strcmp(firstArgument,ls) == 0){
    Ls();
  }
  //check if cd
  else if(strcmp(firstArgument,cd) == 0){
    Cd(argumentLine);
  }
  //check if mkdir
  else if(strcmp(firstArgument,mkdir) == 0){
    Mkdir(argumentLine);
  }
  //check if rmdir
  else if(strcmp(firstArgument,rmdir) == 0){
    Rmdir(argumentLine);
  }
  //check if executing a program
  else if(strstr(firstArgument, execute) != NULL){
    FileProgram(argumentLine, redirect);
  }
  //check if cat
  else if(strcmp(firstArgument, cat) == 0){
    FileProgram(argumentLine, false);
  }
  //else
  else {
    printf("%s: command not found\n", firstArgument);
  }
  return 0;
}
//define Empty function
int Empty(){
  return 0;
}
//define Echo function
void Echo(char* argumentLine[]){
  int argumentCounter = 1;
  char* print = argumentLine[argumentCounter++];
  if(print == 0){
    printf("\n");
  }
  else {
    while(1){
      printf("%s", print);
      print = argumentLine[argumentCounter++];
      if(print == 0){
        printf("\n");
        break;
      }
      printf(" ");
    }
  }
}
//define Exit function
int Exit(){
  return 1;
}
//define Ls function
void Ls(){
  DIR *directory;
  struct dirent *files;
  char* doubleDots = "..";
  char* dot = ".";

  directory = opendir(".");
  if(directory == NULL){
    printf("Error! Unalbe to open directory\n");
  }
  else {
    while(1){
      files = readdir(directory);
      if(files == NULL){
        printf("\n");
        break;
      }
      if(strcmp(files->d_name,doubleDots) != 0 && strcmp(files->d_name,dot) != 0)
      printf("%s ", files->d_name);
    }
  }
  closedir(directory);
}
//define Cd function
void Cd(char* argumentLine[]){
  //DIR *directory;
  //struct dirent *files;
  char* pathGoTo;
  if(argumentLine[1] == 0){
    pathGoTo = getenv("HOME");
  }
  else {
    pathGoTo = argumentLine[1];
  }
  int returN = chdir(pathGoTo);
  if(returN == -1){
    ErrorMessage();
  }
}
//define Mkdir function
void Mkdir(char* argumentLine[]){
  int returN =  mkdir(argumentLine[1], S_IRWXU | S_IRGRP | S_IXGRP | S_IROTH);
  if(returN == -1){
    ErrorMessage();
  }
}
//define Rmdir function
void Rmdir(char* argumentLine[]){
  int returN = rmdir(argumentLine[1]);
  if(returN == -1){
    ErrorMessage();
  }
}
//define ErrorMessage function
void ErrorMessage(){
  if(errno == EACCES){
    printf("error: Permission denied\n");
  }
  else if(errno == EADDRINUSE){
    printf("error: Address already in use\n");
  }
  else if(errno == ENOENT){
    printf("error: No such file or directory\n");
  }
  else if(errno == ENOTDIR){
    printf("error: Not a directory\n");
  }
  else if(errno == EEXIST){
    printf("error: files exist in the folder\n");
  }
  else {
    printf("error\n");
  }
}
//define to read a program file
void FileProgram(char** argumentLine, bool redirect){
  pid_t pid;
  int defout;
  int file;
  int status;
  pid = fork();
  if(pid < 0){
    printf("Error: fork child failed.\n");
    exit(1);
  }
  else if(pid == 0){
    if(redirect){
      int filePosition = getArrowIndex(argumentLine);
      defout = dup(1);
      file = open(argumentLine[filePosition+1],O_CREAT|O_RDWR,0644);
      argumentLine[filePosition] = 0;
      argumentLine[filePosition+1] = 0;
      dup2(file,1);
      if(execvp(*argumentLine,argumentLine) < 0){
        exit(1);
      }
      dup2(defout,1);
      close(file);
    }
    else{
      if(execvp(*argumentLine,argumentLine) < 0){
        perror("execvp");
        exit(1);
      }
    }
  }
  else {
    while(wait(&status) != pid){}
  }
}
//find the arrow position
int getArrowIndex(char** argumentLine){
  char* arrow = ">";
  int counter = 0;
  while(1){
    if(strcmp(argumentLine[counter++],arrow) == 0){
      return --counter;
    }
  }
  return counter;
}
