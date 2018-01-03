using UnityEngine;

public class PillManager : MonoBehaviour {

    public float appearTime = 20f;
    public GameObject pill;

    float delay;
    bool appeared;
    // Use this for initialization
    void Start()
    {
        pill.SetActive(false);
        appeared = false;
        delay = 2400f;
        appearTime *= 10f;
    }

    // Update is called once per frame
    void Update()
    {
        if (appeared)
        {
            delay -= 1f;
            if (delay <= 0 && !pill.activeSelf)
            {
                pill.SetActive(true);
                delay = 2400f;
            }
            else if (delay <= 0)
            {
                delay = 2400f;
            }
        }
        else
        {
            appearTime -= 1f;
            if (appearTime <= 0)
            {
                pill.SetActive(true);
                appeared = true;
            }
        }
    }
}
