#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <pthread.h>
#include <semaphore.h>

void *thread_function();
void producer();
void consumer();

sem_t lock;
sem_t room;
sem_t numOfItems;
int bufferItem;
int buffer[3];
const int sizeofbuffer = 3;

int main(int argc, char** argv){
  int num_threads;
  pthread_t* threads;
  if(argc < 2){
    printf("Error: type in enough number of arguments.\n");
    return 0;
  }
  num_threads = atoi(argv[1]);
  threads = (pthread_t*) calloc(num_threads,sizeof(pthread_t));
  if(sem_init(&lock,0,1) < 0 || sem_init(&numOfItems,0,0) < 0 || sem_init(&room,0,sizeofbuffer) < 0){
    perror("sem_init");
    return 0;
  }
  bufferItem = 0;
  int returN;
  for(long id=0;id<num_threads;id++){
    if((returN=pthread_create(&threads[id],NULL,&thread_function,(void*)id))){
      printf("Created Failure with id: %ld", id);
    }
  }

  for(long id=0;id<num_threads;id++){
    pthread_join(threads[id],NULL);
  }
  sem_destroy(&lock);
  sem_destroy(&room);
  sem_destroy(&numOfItems);
  free(threads);
  return 0;
}
void *thread_function(void* arg){
  int process_id = (int) arg;
  int random = process_id/4;
  if(process_id % 2 == 0){
    producer(process_id,buffer);
  }
  else {
    consumer(process_id,buffer);
  }
}
void producer(int process_id,int buffer[]){
  int produced;
  for(int counter = 0;counter < 20;counter++){
    produced = rand()%10;
    sem_wait(&room);
    sem_wait(&lock);
    buffer[bufferItem++] = produced;
    printf("%d: Produced %d\n", process_id, produced);
    sem_post(&lock);
    sem_post(&numOfItems);

  }
}
void consumer(int process_id,int buffer[]){
  int consumed;
  for(int counter = 0;counter < 20;counter++){
    sem_wait(&numOfItems);
    sem_wait(&lock);
    int take = buffer[--bufferItem];
    buffer[bufferItem] = 0;
    consumed = take;
    printf("%d: Consumed %d\n", process_id, consumed);
    sem_post(&lock);
    sem_post(&room);

  }
}
