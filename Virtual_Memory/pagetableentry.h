#ifndef PAGETABLEENTRY_H
#define PAGETABLEENTRY_H

class PageTableEntry {
  private:
    bool inMemory;
    int frame;
  public:
    int getFrame();
    bool InMemory();
    void swapToDisk(int diskFrame);
    void swapToMemory(int memFrame);
    PageTableEntry();
};
#endif
