using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

public class BackgroundMusic : MonoBehaviour {
    float volume;
    GameObject[] musics;
    static int theindex;
	// Use this for initialization
	void Awake () {
        
        if (QuitOnClick.load)
        {
            theindex = PlayerPrefs.GetInt("Index");
        }
        else
        {
            theindex = 0;
        }
        if(theindex == 9 || theindex == 8)
        {
            GetComponent<AudioSource>().volume = 0;
        }
        else
        {
            if (PlayerPrefs.HasKey("Volume"))
            {
                GetComponent<AudioSource>().volume = PlayerPrefs.GetFloat("Volume");
            }
        }
        int y = SceneManager.GetActiveScene().buildIndex;
        PlayerPrefs.SetInt("Index", y);
    }
    void Update()
    {
        GetComponent<AudioSource>().volume = PlayerPrefs.GetFloat("Volume")* PlayerPrefs.GetFloat("Volume");
    }
}
