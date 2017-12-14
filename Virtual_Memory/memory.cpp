#include "memory.h"
#include "pagetableentry.h"

Memory::Memory(){
  nextframe = 0;
  full = false;
}

void Memory::setFrame(int frame, PageTableEntry* pte){
  frames[frame] = pte;
}

PageTableEntry* Memory::getFrame(int frame){
  return frames[frame];
}

int Memory::getFreePage(){
  return 0;
}

int Memory::findSwapPage(){
  return nextframe;
}

int Memory::convert(int frame){
  return 0;
}

int Memory::getAvailableFrame(){
  return nextframe;
}

void Memory::getIncremented(){
  nextframe = (nextframe+1)%30;
  if(nextframe == 0){
    full = true;
  }
}

bool Memory::isFull(){
  return full;
}
