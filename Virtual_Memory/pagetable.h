#ifndef PAGETABLE_H
#define PAGETABLE_H
#include "pagetableentry.h"

class PageTable {
  private:
    PageTableEntry* entries[64];
  public:
    void setPTE(int pt, PageTableEntry *pte);
    PageTableEntry* getPTE(int page);
    PageTable();
};
#endif
