#ifndef PROCESSTABLE_H
#define PROCESSTABLE_H
#include "pagetable.h"

class ProcessTable {
  private:
    PageTable* procPageTable[32];//N = 32
  public:
    void setProcPT(int pid, PageTable *pt);
    PageTable* getProcPT(int pid);
    ProcessTable();
};
#endif
