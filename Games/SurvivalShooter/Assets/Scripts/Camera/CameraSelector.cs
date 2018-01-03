using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CameraSelector : MonoBehaviour {
    public GameObject Camera1;
    public GameObject Camera2;
    public GameObject player;
    public GameObject gun;
    Vector3 originalPos;
    CharacterController c;
    public static bool activate;
    public static bool activated;
    float duration = 50f;
    Vector3 offset;
    Transform camTransform;
    Vector3 playerOrigin;
    GameObject[] spawn;
    int activateLimit;

    // Use this for initialization
    void Start () {
        Camera1.SetActive(false);
        Camera2.SetActive(true);
        c = player.GetComponent<CharacterController>();
        c.enabled = false;
        activate = false;
        activateLimit = 200;
    }

    // Update is called once per frame
    void Update()
    {
        if (Input.GetKeyDown(KeyCode.C) && !activate)
        {
            if (Camera1.activeSelf)
            {
                Camera2.SetActive(true);
                gun.SetActive(true);
                Camera1.SetActive(false);
                c.enabled = false;
            }
            else if (Camera2.activeSelf)
            {
                Camera1.SetActive(true);
                c.enabled = true;
                Camera2.SetActive(false);
                gun.SetActive(false);
            }
        }
        if (Input.GetKeyDown(KeyCode.Q) && !activate && ScoreManager.levelscore >= activateLimit)
        {
            activate = true;
            if (Camera1.activeSelf)
            {
                camTransform = Camera1.transform;
            }
            else
            {
                camTransform = Camera2.transform;
            }
            originalPos = camTransform.position;
            playerOrigin = player.transform.position;
        }
        if (activate)
        {
            Vector3 temp = camTransform.position;
            camTransform.position = originalPos + Random.insideUnitSphere * 0.7f;
            offset = player.transform.position - playerOrigin;
            duration -= 1f;
            spawn = GameObject.FindGameObjectsWithTag("Enemy");
            foreach (GameObject go in spawn){
                go.GetComponent<EnemyHealth>().TakeDamage(10);
            }
            if(duration <= 0f)
            {
                duration = 50f;
                activate = false;
                camTransform.position = originalPos + offset;
                ScoreManager.levelscore = 0;
                activated = true;
            }
        }
    }
}
