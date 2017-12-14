#include "processtable.h"
#include "pagetable.h"

ProcessTable::ProcessTable(){

}

void ProcessTable::setProcPT(int pid, PageTable *pt){
  procPageTable[pid] = pt;
}

PageTable* ProcessTable::getProcPT(int pid){
  return procPageTable[pid];
}
