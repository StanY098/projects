#include "pagetableentry.h"

PageTableEntry::PageTableEntry(){
  inMemory = false;
  frame = -1;
}

int PageTableEntry::getFrame(){
  return frame;
}

bool PageTableEntry::InMemory(){
  return inMemory;
}

void PageTableEntry::swapToDisk(int diskFrame){
  frame = diskFrame;
  inMemory = false;
}

void PageTableEntry::swapToMemory(int memFrame){
  frame = memFrame;
  inMemory = true;
}
