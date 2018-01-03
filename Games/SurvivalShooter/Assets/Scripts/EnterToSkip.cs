using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class EnterToSkip : MonoBehaviour {

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        if (Input.GetAxis("Submit") != 0)
        {
            int y = SceneManager.GetActiveScene().buildIndex;
            if(y == 7)
            {
                Destroy(GameObject.FindGameObjectWithTag("BackGroundMusic"));
            }
            else
            {
                DontDestroyOnLoad(GameObject.FindGameObjectWithTag("BackGroundMusic"));
            }
            SceneManager.LoadScene(y + 1);
        }

    }
}
