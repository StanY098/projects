#ifndef MEMORY_H
#define MEMORY_H
#include "pagetableentry.h"

class Memory {
  private:
    PageTableEntry* frames[30];
    int nextframe;
    bool full;
  public:
    void setFrame(int frame, PageTableEntry *pte);
    PageTableEntry* getFrame(int frame);
    int getFreePage();
    int findSwapPage();
    int convert(int frame);
    int getAvailableFrame();
    bool isFull();
    void getIncremented();
    Memory();
};
#endif
