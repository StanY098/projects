#include "pagetable.h"
#include "pagetableentry.h"

PageTable::PageTable(){

}

void PageTable::setPTE(int pt, PageTableEntry *pte){
  entries[pt] = pte;
}

PageTableEntry* PageTable::getPTE(int page){
  return entries[page];
}
