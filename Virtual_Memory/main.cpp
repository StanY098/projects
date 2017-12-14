#include <fstream>
#include <iostream>
#include "pagetable.h"
#include "processtable.h"
#include "pagetableentry.h"
#include "memory.h"

using namespace std;

void do_new(int n);
void do_switch(int n);
void do_access(int n);

ifstream infile("VMInput.txt");
string command;
int index;
int countAccess;
int countHit;
int countMiss;
int countCompulsory;
ProcessTable* pt;
PageTable* current_page_table;
Memory* m;

int main(){
  pt = new ProcessTable();
  m = new Memory();
  countAccess = 0;
  countHit = 0;
  countMiss = 0;
  countCompulsory = 0;
  while(infile >> command >> index){
    if(command == "new"){
      do_new(index);
    }
    else if(command == "switch"){
      do_switch(index);
    }
    else if(command == "access"){
      do_access(index);
    }
  }
  cout << "Access: " << countAccess << endl;
  cout << "Hits: " << countHit << endl;
  cout << "Misses: " << countMiss << endl;
  cout << "Compulsory Misses: " << countCompulsory << endl;
  return 0;
}

void do_new(int n){
  PageTable* pageT = new PageTable();
  pt->setProcPT(n,pageT);
}

void do_switch(int n){
  current_page_table = pt->getProcPT(n);
}

void do_access(int n){
  countAccess++;
  int page = n >> 10;
  int offset = n - (page << 10);
  PageTableEntry* pte = current_page_table -> getPTE(page);
  if(pte == 0){
    //countMiss++;
    countCompulsory++;
    current_page_table -> setPTE(page, new PageTableEntry());
  }
  pte = current_page_table -> getPTE(page);
  if(pte -> InMemory()){
    countHit++;
    int frame = pte -> getFrame();
    pte = m -> getFrame(frame);
  }
  else{
    countMiss++;
    int frame = m -> getAvailableFrame();
    if(m -> isFull()){
      PageTableEntry* pteSwap = m -> getFrame(frame);
      pteSwap -> swapToDisk(-1);
    }

    pte -> swapToMemory(frame);
    m -> setFrame(frame,pte);
    m -> getIncremented();
  }
}
